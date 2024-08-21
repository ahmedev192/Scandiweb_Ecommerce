<?php
namespace App\Models;

class FurnitureProduct extends Product
{
    private $heightCm;
    private $widthCm;
    private $lengthCm;

    public function __construct($sku, $name, $price, $heightCm = null, $widthCm = null, $lengthCm = null)
    {
        parent::__construct($sku, $name, $price);
        if ($heightCm !== null && $widthCm !== null && $lengthCm !== null) {
            $this->setHeightCm($heightCm);
            $this->setWidthCm($widthCm);
            $this->setLengthCm($lengthCm);
        }
    }

    public function getType(): string
    {
        return 'Furniture';
    }

    public function setHeightCm($heightCm): void
    {
        $this->heightCm = $heightCm;
    }

    public function getHeightCm(): float
    {
        return $this->heightCm;
    }

    public function setWidthCm($widthCm): void
    {
        $this->widthCm = $widthCm;
    }

    public function getWidthCm(): float
    {
        return $this->widthCm;
    }

    public function setLengthCm($lengthCm): void
    {
        $this->lengthCm = $lengthCm;
    }

    public function getLengthCm(): float
    {
        return $this->lengthCm;
    }

    protected function saveSpecific(): void
    {
        $stmt = $this->db->prepare("INSERT INTO product_furniture (id, height_cm, width_cm, length_cm) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iddd", $this->id, $this->heightCm, $this->widthCm, $this->lengthCm);
        $stmt->execute();
        $stmt->close();
    }

    public function getAttribute(): string
    {
        return "Dimensions: " . ProductFactory::escape($this->heightCm) . "x" . ProductFactory::escape($this->widthCm) . "x" . ProductFactory::escape($this->lengthCm) . " CM";
    }

    protected function loadSpecific($id): void
    {
        $stmt = $this->db->prepare("SELECT height_cm, width_cm, length_cm FROM product_furniture WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->setHeightCm($row['height_cm']);
            $this->setWidthCm($row['width_cm']);
            $this->setLengthCm($row['length_cm']);
        }
        $stmt->close();
    }

    public function display()
    {
        return [
            'id' => ProductFactory::escape($this->id),
            'sku' => ProductFactory::escape($this->sku),
            'name' => ProductFactory::escape($this->name),
            'price' => ProductFactory::escape($this->price),
            'additional_attributes' => "Dimensions: " . ProductFactory::escape($this->heightCm) . "x" . ProductFactory::escape($this->widthCm) . "x" . ProductFactory::escape($this->lengthCm) . " CM",
        ];
    }

    protected function deleteSpecific(): void
    {
        $stmt = $this->db->prepare("DELETE FROM product_furniture WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }
}
