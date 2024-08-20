<?php

namespace App\Models;

include $_SERVER['DOCUMENT_ROOT'] . '/app/Config/Database.php';

use App\Config\Database;

class ProductFactory
{
    private static $productMap = [
        'DVD' => DvdProduct::class,
        'Book' => BookProduct::class,
        'Furniture' => FurnitureProduct::class
    ];

    public static function create($type, $sku, $name, $price, $attributes = [], $checkSku = false)
    {
        if (!self::isValidType($type)) {
            throw new \Exception("Invalid product type");
        }

        if ($checkSku && self::skuExists($sku)) {
            throw new \Exception("SKU already exists, please choose a different SKU");
        }

        $attributesArray = self::parseAttributes($attributes);

        $productClass = self::$productMap[$type];

        return new $productClass($sku, $name, $price, ...array_values($attributesArray));
    }



    private static function isValidType($type)
    {
        return array_key_exists($type, self::$productMap);
    }

    private static function parseAttributes($attributes)
    {
        if (is_string($attributes)) {
            $attributes = json_decode($attributes, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid attributes format");
            }
        }

        if (!is_array($attributes)) {
            throw new \Exception("Attributes should be an array or a JSON string");
        }

        return $attributes;
    }



    private static function skuExists($sku)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE sku = ?");
        $stmt->bind_param('s', $sku);
        $stmt->execute();
        $count = 0;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }

    public static function load($id)
    {
        // Fetch the product type based on the product ID
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT type FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new \Exception("Product not found.");
        }

        $row = $result->fetch_assoc();
        $type = $row['type'];

        if (!self::isValidType($type)) {
            throw new \Exception("Invalid product type.");
        }

        $productClass = self::$productMap[$type];
        $product = new $productClass(null, null, null);
        $product->load($id);

        return $product;
    }


    public static function createAndSave($type, $sku, $name, $price, $attributes = [], $checkSku = true)
    {
        // Use the factory to create the product
        $product = self::create($type, $sku, $name, $price, $attributes, $checkSku);

        // Save the product using the model's save method
        $product->save();

        return $product;
    }


    public static function getAllProducts()
    {
        $db = Database::getConnection();
        $result = $db->query("SELECT id, sku, name, price, type FROM products ORDER BY id");

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $productClass = self::$productMap[$row['type']];
            $product = new $productClass($row['sku'], $row['name'], $row['price']);
            $product->load($row['id']);
            $products[] = $product;
        }

        return $products;
    }
}
