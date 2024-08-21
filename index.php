<?php


include __DIR__ . '/app/Config/Database.php';
include __DIR__ . '/app/Controllers/ProductController.php';
include __DIR__ . '/autoload.php';

use App\Controllers\ProductController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Log the requested URI
error_log("Requested URI: " . $uri);

$controller = new ProductController();

if ($uri === '/') {
    $controller->listProducts();
} elseif ($uri === '/addproduct') {
    $controller->AddProductGet();
} elseif ($uri === '/saveproduct') {
    $controller->AddProductPost();
} elseif ($uri === '/deleteproducts') {
    $controller->deleteProducts();
} else {
    http_response_code(404);
    echo "404 Not Found for URI: " . $uri;
}
