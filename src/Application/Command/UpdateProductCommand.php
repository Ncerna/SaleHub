<?php
namespace App\Application\Command;

/**
 * Comando para actualizar un producto.
 */
class UpdateProductCommand
{
    public int $id;
    public ?string $name;
    public ?string $code;
    public ?string $barcode;
    public ?float $price;
    public ?string $description;
    public ?int $stock;
    public ?int $minimumStock;
    public ?int $idConcept;
    public ?string $photo;
    public ?int $categoryId;
    public ?int $igvAffectationId;
    public ?string $igvAffectCode;
    public ?string $unitId;
    public ?string $unit;
    public ?float $unitCost;
    public ?float $unitPrice;
    public ?float $priceWithIgv;
    public ?float $priceWithoutIgv;
    public ?float $bulkPriceWithIgv;
    public ?float $bulkPriceWithoutIgv;
    public ?float $offerPriceWithIgv;
    public ?float $offerPriceWithoutIgv;
    public ?float $totalCost;
    public ?float $igvFactor;
    public ?float $igvRate;
    public ?int $companyId;
    public ?int $branchId;
    public ?int $warehouseId;

    /**
     * Constructor que recibe el ID del producto y un array con los datos a actualizar.
     *
     * @param int $id Identificador del producto a actualizar.
     * @param array $data Datos para actualizar el producto.
     */
    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->name = $data['name'] ?? null;
        $this->code = $data['code'] ?? null;
        $this->barcode = $data['barcode'] ?? null;
        $this->price = isset($data['price']) ? (float)$data['price'] : null;
        $this->description = $data['description'] ?? null;
        $this->stock = isset($data['stock']) ? (int)$data['stock'] : null;
        $this->minimumStock = isset($data['minimumStock']) ? (int)$data['minimumStock'] : null;
        $this->idConcept = isset($data['idConcept']) ? (int)$data['idConcept'] : null;
        $this->photo = $data['photo'] ?? null;
        $this->categoryId = isset($data['categoryId']) ? (int)$data['categoryId'] : null;
        $this->igvAffectationId = isset($data['igvAffectationId']) ? (int)$data['igvAffectationId'] : null;
        $this->igvAffectCode = $data['igvAffectCode'] ?? null;
        $this->unitId = $data['unitId'] ?? null;
        $this->unit = $data['unit'] ?? null;
        $this->unitCost = isset($data['unitCost']) ? (float)$data['unitCost'] : null;
        $this->unitPrice = isset($data['unitPrice']) ? (float)$data['unitPrice'] : null;
        $this->priceWithIgv = isset($data['priceWithIgv']) ? (float)$data['priceWithIgv'] : null;
        $this->priceWithoutIgv = isset($data['priceWithoutIgv']) ? (float)$data['priceWithoutIgv'] : null;
        $this->bulkPriceWithIgv = isset($data['bulkPriceWithIgv']) ? (float)$data['bulkPriceWithIgv'] : null;
        $this->bulkPriceWithoutIgv = isset($data['bulkPriceWithoutIgv']) ? (float)$data['bulkPriceWithoutIgv'] : null;
        $this->offerPriceWithIgv = isset($data['offerPriceWithIgv']) ? (float)$data['offerPriceWithIgv'] : null;
        $this->offerPriceWithoutIgv = isset($data['offerPriceWithoutIgv']) ? (float)$data['offerPriceWithoutIgv'] : null;
        $this->totalCost = isset($data['totalCost']) ? (float)$data['totalCost'] : null;
        $this->igvFactor = isset($data['igvFactor']) ? (float)$data['igvFactor'] : null;
        $this->igvRate = isset($data['igvRate']) ? (float)$data['igvRate'] : null;
        $this->companyId = isset($data['companyId']) ? (int)$data['companyId'] : null;
        $this->branchId = isset($data['branchId']) ? (int)$data['branchId'] : null;
        $this->warehouseId = isset($data['warehouseId']) ? (int)$data['warehouseId'] : null;
    }
}
