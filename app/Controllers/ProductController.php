<?php

namespace App\Controllers;


use App\Models\ProductFactory;
use App\Config\Database;

class ProductController
{
    public function listProducts()
    {
        $products = ProductFactory::getAllProducts();
        $displayProducts = []; // Declare the array before using it

        foreach ($products as $product) {
            $displayProducts[] = $product->display();
        }

        include './app/Views/list_products.php';
    }



  public function AddProductPost()
{
    header('Content-Type: application/json');

    $response = ['success' => false];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decode JSON data from the request body
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            $type = $input['type'];
            $sku = $input['sku'];
            $name = $input['name'];
            $price = $input['price'];
            $attributes = $input['attributes'];

            try {
                // Create and save the product
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

    echo json_encode($response);
}



    public function AddProductGet()
    {
        // This will load the form view
        include './app/Views/add_product.php';
    }


  public function deleteProducts()
{
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() === JSON_ERROR_NONE && isset($input['ids'])) {
        $idsToDelete = $input['ids'];

        try {
            foreach ($idsToDelete as $id) {
                $product = ProductFactory::load($id);
                if ($product) {
                    $product->delete();
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
