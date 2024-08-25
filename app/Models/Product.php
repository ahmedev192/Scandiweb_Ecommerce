<?php

namespace App\Models;

use App\Config\Database;

abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $db;

    // Initialize product with SKU, name, and price
    public function __construct($sku, $name, $price)
    {
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        $this->db = Database::getConnection();
    }

    // Setters and getters for product properties
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setSku($sku): void
    {
        $this->sku = ProductFactory::escape($sku);
    }

    public function getSku(): string
    {
        return ProductFactory::escape($this->sku);
    }

    public function setName($name): void
    {
        $this->name = ProductFactory::escape($name);
    }

    public function getName(): string
    {
        return ProductFactory::escape($this->name);
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    // Save product to the database
    public function save(): void
    {
        $stmt = $this->db->prepare("INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)");
        $type = $this->getType();
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $type);
        $stmt->execute();
        $this->id = $stmt->insert_id;
        $stmt->close();
        $this->saveSpecific(); // Save product-specific details
    }

    // Load product from the database by ID
    public function load($id): void
    {
        $stmt = $this->db->prepare("SELECT sku, name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->id = $id;
            $this->sku = ProductFactory::escape($row['sku']);
            $this->name = ProductFactory::escape($row['name']);
            $this->price = ProductFactory::escape($row['price']);
        } else {
            throw new \Exception("Product not found");
        }

        $stmt->close();
        $this->loadSpecific($id); // Load product-specific details
    }

    // Delete product from the database
    public function delete(): void
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();

        $this->deleteSpecific(); // Delete product-specific details
    }

    // Abstract methods to be implemented by subclasses
    abstract public function getType(): string;
    abstract protected function saveSpecific(): void;
    abstract protected function loadSpecific($id): void;
    abstract protected function deleteSpecific(): void;
    public abstract function display();
}
