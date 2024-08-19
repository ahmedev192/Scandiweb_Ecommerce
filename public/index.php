<?php
require_once '../app/Config/database.php';
require_once '../app/Controllers/ProductController.php';
require_once __DIR__ . '/../autoload.php';

use App\Controllers\ProductController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Log the requested URI
error_log("Requested URI: " . $uri);

$controller = new ProductController();

if ($uri === '/public/') {
    $controller->listProducts();
} elseif ($uri === '/public/addproduct') {
    $controller->AddProductGet();
} elseif ($uri === '/public/saveproduct') {
    $controller->AddProductPost();
} elseif ($uri === '/public/deleteproducts') {
    $controller->deleteProducts();
} else {
    http_response_code(404);
    echo "404 Not Found for URI: " . $uri;
}
