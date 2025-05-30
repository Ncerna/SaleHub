<?php
namespace SaleHub\Domain\Entity;

/**
 * Representa un producto en el sistema.
 */
class Product {
    private string $id;
    private string $name;                  // Nombre del producto
    private string $code;                  // Código del producto
    private ?string $barcode;              // Código de barras del producto (nullable)
    private float $price;                  // Precio del producto
    private ?string $description;          // Descripción del producto (nullable)
    private int $stock;                   // Stock del producto
    private int $minimum_stock;           // Stock mínimo del producto
    private ?int $id_concept;             // ID del concepto relacionado (nullable)
    private ?string $photo;               // Foto del producto (nullable)
    private ?int $categoryId;             // ID de la categoría (nullable)
    private ?int $igvAffectationId;       // ID del tipo de afectación IGV (nullable)
    private ?string $igvAffectCode;       // Código de afectación IGV (nullable)
    private ?string $unitId;              // ID de la unidad de medida (nullable)
    private ?string $unit;                // Unidad de medida (nullable)
    private float $unitCost;              // Costo de producción por unidad
    private float $unitPrice;             // Precio de venta por unidad
    private float $priceWithIgv;          // Precio unitario con IGV
    private float $priceWithoutIgv;       // Precio unitario sin IGV
    private float $bulkPriceWithIgv;      // Precio mayorista con IGV
    private float $bulkPriceWithoutIgv;   // Precio mayorista sin IGV
    private float $offerPriceWithIgv;     // Precio en oferta con IGV
    private float $offerPriceWithoutIgv;  // Precio en oferta sin IGV
    private float $totalCost;             // Costo total
    private float $igvFactor;             // Factor del IGV
    private float $igvRate;               // Tasa del IGV
    private ?int $companyId;              // ID de la empresa (nullable)
    private ?int $branchId;               // ID de la sucursal (nullable)
    private ?int $warehouseId;            // ID del almacén (nullable)
    private \DateTime $createdAt;         // Fecha de creación
    private \DateTime $updatedAt;         // Fecha de actualización

    public function __construct(
        string $id,
        string $name,
        string $code,
        ?string $barcode,
        float $price,
        ?string $description,
        int $stock,
        int $minimum_stock,
        ?int $id_concept,
        ?string $photo,
        ?int $categoryId,
        ?int $igvAffectationId,
        ?string $igvAffectCode,
        ?string $unitId,
        ?string $unit,
        float $unitCost,
        float $unitPrice,
        float $priceWithIgv,
        float $priceWithoutIgv,
        float $bulkPriceWithIgv,
        float $bulkPriceWithoutIgv,
        float $offerPriceWithIgv,
        float $offerPriceWithoutIgv,
        float $totalCost,
        float $igvFactor,
        float $igvRate,
        ?int $companyId,
        ?int $branchId,
        ?int $warehouseId,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->barcode = $barcode;
        $this->price = $price;
        $this->description = $description;
        $this->stock = $stock;
        $this->minimum_stock = $minimum_stock;
        $this->id_concept = $id_concept;
        $this->photo = $photo;
        $this->categoryId = $categoryId;
        $this->igvAffectationId = $igvAffectationId;
        $this->igvAffectCode = $igvAffectCode;
        $this->unitId = $unitId;
        $this->unit = $unit;
        $this->unitCost = $unitCost;
        $this->unitPrice = $unitPrice;
        $this->priceWithIgv = $priceWithIgv;
        $this->priceWithoutIgv = $priceWithoutIgv;
        $this->bulkPriceWithIgv = $bulkPriceWithIgv;
        $this->bulkPriceWithoutIgv = $bulkPriceWithoutIgv;
        $this->offerPriceWithIgv = $offerPriceWithIgv;
        $this->offerPriceWithoutIgv = $offerPriceWithoutIgv;
        $this->totalCost = $totalCost;
        $this->igvFactor = $igvFactor;
        $this->igvRate = $igvRate;
        $this->companyId = $companyId;
        $this->branchId = $branchId;
        $this->warehouseId = $warehouseId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters y setters aquí (omito por brevedad, pero se recomienda implementarlos)
    
    public function getId(): string {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
   // private  // Asegúrate de declarar la propiedad

public function getBarcode(): ?string {
    return $this->barcode;
}

public function setBarcode(?string $barcode): void {
    $this->barcode = $barcode;
}

    // ... (otros getters)
}
