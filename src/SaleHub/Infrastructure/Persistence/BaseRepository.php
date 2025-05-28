<?php
namespace SaleHub\Infrastructure\Persistence;

use SaleHub\Infrastructure\ConnectionPool\CustomConnectionPool;
use Exception;
use mysqli_stmt;

abstract class BaseRepository {
    protected \mysqli $conexion;
    private string $tenantIdentifier;

    public function __construct(string $tenantIdentifier) {
        $this->tenantIdentifier = $tenantIdentifier;
        $this->conexion = ConnectionPool::getConnection($tenantIdentifier);
    }

    abstract protected function getTableName(): string;

    protected function executeQuery(string $query, array $params = []): mysqli_stmt {
        try {
            $stmt = $this->conexion->prepare($query);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
            }
            if (!empty($params)) {
                $types = $this->getParamTypes($params);
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception("ERROR::" . $e->getMessage());
        }
    }

    protected function getTableColumns(): array {
        try {
            $tableName = $this->getTableName();
            $query = "SHOW COLUMNS FROM $tableName";
            $result = $this->conexion->query($query);
            if (!$result) {
                throw new Exception("Error al obtener las columnas: " . $this->conexion->error);
            }
            $columns = [];
            while ($row = $result->fetch_assoc()) {
                $columns[] = $row['Field'];
            }
            return $columns;
        } catch (Exception $e) {
            throw new Exception("ERROR::" . $e->getMessage());
        }
    }

    public function getById(int $id, string $className) {
        $table = $this->getTableName();
        $query = "SELECT * FROM $table WHERE id = ? AND status NOT IN (-1, 0)";
        $stmt = $this->executeQuery($query, [$id]);
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return null;
        }
        $data = $result->fetch_assoc();
        return $className::fromArray($data);
    }

    public function getAll(string $className, int $limit = 1000): array {
        $table = $this->getTableName();
        $query = "SELECT * FROM $table LIMIT ?";
        $stmt = $this->executeQuery($query, [$limit]);
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $className::fromArray($row);
        }
        return $items;
    }

    protected function getParamTypes(array $params): string {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }

    public function list(string $className, int $page = 1, int $size = 10): array {
        $table = $this->getTableName();
        $offset = ($page - 1) * $size;
        $query = "SELECT * FROM $table LIMIT ? OFFSET ?";
        $stmt = $this->executeQuery($query, [$size, $offset]);
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $className::fromArray($row);
        }
        $countQuery = "SELECT COUNT(*) as total FROM $table";
        $countResult = $this->conexion->query($countQuery);
        $total = $countResult->fetch_assoc()['total'];
        return [
            'data' => $items,
            'page' => $page,
            'size' => $size,
            'total' => $total,
            'total_pages' => ceil($total / $size)
        ];
    }

    protected function buildInsertQuery(array $columns, string $tableName): string {
        return "INSERT INTO $tableName (" . implode(", ", $columns) . ") VALUES (" . str_repeat("?, ", count($columns) - 1) . "?)";
    }

    protected function buildUpdateQuery(array $columns, string $tableName): string {
        return "UPDATE $tableName SET " . implode(", ", array_map(fn($col) => "$col = ?", $columns)) . " WHERE id = ?";
    }

    protected function getParamsFromData(array $data, array $columns): array {
        return array_map(fn($col) => $data[$col] ?? null, $columns);
    }

    protected function getFilteredColumns(array $columnsToExclude = ['id', 'created_at', 'updated_at']): array {
        return array_filter($this->getTableColumns(), fn($col) => !in_array($col, $columnsToExclude));
    }

    protected function startTransaction(): void {
        $this->conexion->begin_transaction();
    }

    protected function commitTransaction(): void {
        $this->conexion->commit();
    }

    protected function rollbackTransaction(): void {
        $this->conexion->rollback();
    }
}
