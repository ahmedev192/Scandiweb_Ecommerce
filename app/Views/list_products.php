<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css">
</head>
<!-- Navigation Bar -->

<body>
    <div class="container mt-5 content">


        <form id="product-list-form">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Product List</h1>
                <div>
                    <a href="../public/addproduct" class="btn btn-primary">ADD</a>
                    <button id="delete-product-btn" class="btn btn-danger">MASS DELETE</button>
                </div>
            </div>
            <div class="top-line">
            </div>
            <div class="row">
                <?php foreach ($displayProducts as $product): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <input type="checkbox" class="delete-checkbox form-check-input" value="<?= $product['id'] ?>">
                                <h5 class="card-title"><?= $product['sku'] ?></h5>
                                <p class="card-text"><?= $product['name'] ?></p>
                                <p class="card-text"><?= $product['price'] ?> $</p>
                                <p class="card-text"><?= $product['additional_attributes'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/Partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/list-products.js"></script>
</body>

</html>