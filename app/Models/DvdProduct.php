<?php
namespace App\Models;

class DvdProduct extends Product
{
    private $sizeMb;

    public function __construct($sku, $name, $price, $sizeMb = null)
    {
        parent::__construct($sku, $name, $price);
        if ($sizeMb !== null) {
            $this->setSizeMb($sizeMb);
        }
    }

    public function getType(): string
    {
        return 'DVD';
    }

    public function setSizeMb($sizeMb): void
    {
        $this->sizeMb = $sizeMb;
    }

    public function getSizeMb(): int
    {
        return $this->sizeMb;
    }

    protected function saveSpecific(): void
    {
        $stmt = $this->db->prepare("INSERT INTO product_dvd (id, size_mb) VALUES (?, ?)");
        $stmt->bind_param("id", $this->id, $this->sizeMb);
        $stmt->execute();
        $stmt->close();
    }

    public function getAttribute(): string
    {
        return "Size: " . ProductFactory::escape($this->sizeMb) . " MB";
    }

    protected function loadSpecific($id): void
    {
        $stmt = $this->db->prepare("SELECT size_mb FROM product_dvd WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->setSizeMb($row['size_mb']);
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
            'additional_attributes' => "Size: " . ProductFactory::escape($this->sizeMb) . " MB",
        ];
    }

    protected function deleteSpecific(): void
    {
        $stmt = $this->db->prepare("DELETE FROM product_dvd WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }
}
