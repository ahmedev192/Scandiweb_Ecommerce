<?php

namespace App\Models;

class BookProduct extends Product
{
    private $weightKg;

    public function __construct($sku, $name, $price, $weightKg = null)
    {
        parent::__construct($sku, $name, $price);
        if ($weightKg !== null) {
            $this->setWeightKg($weightKg);
        }
    }

    public function getType(): string
    {
        return 'Book';
    }

    public function setWeightKg($weightKg): void
    {
        $this->weightKg = $weightKg;
    }

    public function getWeightKg(): float
    {
        return $this->weightKg;
    }

    protected function saveSpecific(): void
    {
        $stmt = $this->db->prepare("INSERT INTO product_book (id, weight_kg) VALUES (?, ?)");
        $stmt->bind_param("id", $this->id, $this->weightKg);
        $stmt->execute();
        $stmt->close();
    }

    protected function loadSpecific($id): void
    {
        $stmt = $this->db->prepare("SELECT weight_kg FROM product_book WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->setWeightKg($row['weight_kg']);
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
            'additional_attributes' => "Weight: " . ProductFactory::escape($this->weightKg) . " KG",
        ];
    }

    protected function deleteSpecific(): void
    {
        $stmt = $this->db->prepare("DELETE FROM product_book WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }
}
