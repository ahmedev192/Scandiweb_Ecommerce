<?php

namespace App\Controllers;


use App\Models\ProductFactory;
use App\Config\Database;

class ProductController
{
    public function listProducts()
    {
        $products = ProductFactory::getAllProducts();

        foreach ($products as $product) {
            $displayProducts[] = $product->display();
        }

        include '../app/Views/list_products.php';
    }


    // public function saveProduct()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $type = $_POST['type'];
    //         $sku = $_POST['sku'];
    //         $name = $_POST['name'];
    //         $price = $_POST['price'];
    //         $attributes = $_POST['attributes'];

    //         try {
    //             ProductFactory::createAndSave($type, $sku, $name, $price, $attributes);
    //             $message = "Product saved successfully!";
    //         } catch (\Exception $e) {
    //             $message = "Error: " . $e->getMessage();
    //             echo $message;
    //         }

    //         include '../app/Views/addproduct.php';
    //     }
    //     include '../app/Views/addproduct.php';
    // }

    public function AddProductPost()
    {
        header('Content-Type: application/json');

        $response = ['success' => false];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'];
            $sku = $_POST['sku'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $attributes = $_POST['attributes'];

            try {
                // Create and save the product
                ProductFactory::createAndSave($type, $sku, $name, $price, $attributes);
                $response['success'] = true;
                $response['message'] = 'Product saved successfully!';
            } catch (\Exception $e) {
                $response['message'] = 'Error: ' . $e->getMessage();
            }
        } else {
            $response['message'] = 'Invalid request method.';
        }

        echo json_encode($response);
    }



    public function AddProductGet()
    {
        // This will load the form view
        include '../app/Views/add_product.php';
    }


    public function deleteProducts()
    {
        $input = json_decode(file_get_contents('php://input'), true);
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
    }
}
