<?php

namespace App\Controllers;


use App\Models\ProductFactory;
use App\Config\Database;

class ProductController
{
    // List all products and display them
    public function listProducts()
    {
        $products = ProductFactory::getAllProducts();
        $displayProducts = []; // Initialize the array to hold display-ready products

        foreach ($products as $product) {
            $displayProducts[] = $product->display(); // Add each product's display to the array
        }

        // Load the list products view
        include './app/Views/list_products.php';
    }

    // Handle the POST request to add a new product
    public function AddProductPost()
    {
        header('Content-Type: application/json');
        $response = ['success' => false];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true); // Decode JSON input

            if (json_last_error() === JSON_ERROR_NONE) {
                $type = $input['type'];
                $sku = $input['sku'];
                $name = $input['name'];
                $price = $input['price'];
                $attributes = $input['attributes'];

                try {
                    // Create and save the new product
                    ProductFactory::createAndSave($type, $sku, $name, $price, $attributes);
                    $response['success'] = true;
                    $response['message'] = 'Product saved successfully!';
                } catch (\Exception $e) {
                    $response['message'] = 'Error: ' . $e->getMessage();
                }
            } else {
                $response['message'] = 'Invalid JSON data.';
            }
        } else {
            $response['message'] = 'Invalid request method.';
        }

        echo json_encode($response); // Send JSON response
    }

    // Display the form for adding a new product
    public function AddProductGet()
    {
        include './app/Views/add_product.php'; // Load the add product view
    }

    // Handle the request to delete products by their IDs
    public function DeleteProducts()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() === JSON_ERROR_NONE && isset($input['ids'])) {
            $idsToDelete = $input['ids'];

            try {
                foreach ($idsToDelete as $id) {
                    $product = ProductFactory::load($id);
                    if ($product) {
                        $product->delete(); // Delete the product if it exists
                    }
                }

                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data or missing ids']);
        }
    }
}
