<?php

namespace App\Models;

use App\Config\database;



abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $db;

    public function __construct($sku, $name, $price)
    {
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        $this->db = database::getConnection();
    }

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
        $this->sku = $sku;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function save(): void
    {
        $stmt = $this->db->prepare("INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)");
        $type = $this->getType();
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $type);
        $stmt->execute();
        $this->id = $stmt->insert_id;
        $stmt->close();
        $this->saveSpecific();
    }


    abstract public function getType(): string;
    abstract protected function saveSpecific(): void;
    public abstract function display();


    abstract public function getAttribute();
    // Add the load method
    public function load($id): void
    {
        $stmt = $this->db->prepare("SELECT sku, name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->id = $id;
            $this->sku = $row['sku'];
            $this->name = $row['name'];
            $this->price = $row['price'];
        } else {
            throw new \Exception("Product not found");
        }

        $stmt->close();
        $this->loadSpecific($id);
    }

    protected abstract function loadSpecific($id);



    public function delete(): void
    {
        // Delete the product from the base products table
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();

        // Delete specific product details
        $this->deleteSpecific();
    }

    protected abstract function deleteSpecific(): void;
}
