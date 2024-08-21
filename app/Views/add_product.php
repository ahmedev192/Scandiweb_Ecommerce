<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

        <link href="../public/css/bootstrap.min.css" rel="stylesheet">

  
  <link rel="stylesheet" href="../public/css/styles.css">
</head>

<body>
       <div class="container mt-5 content">
        <form id="product_form">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Product Add</h2>
                <div>
                    <button type="button" id="saveButton" class="btn btn-primary">Save</button>
                    <button id="cancelButton" type="button" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
            <div class="top-line mb-4"></div>
            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" class="form-control" id="price" required>
            </div>
            <div class="mb-3">
                <label for="productType" class="form-label">Type Switcher</label>
                <select class="form-select" id="productType" required>
                    <option value="">Select Type</option>
                    <option value="DVD">DVD</option>
                    <option value="Book">Book</option>
                    <option value="Furniture">Furniture</option>
                </select>
            </div>

            <!-- DVD Specific Field -->
            <div id="dvdFields" class="hidden mb-3">
                <label for="size" class="form-label">Size (MB)</label>
                <input type="number" class="form-control" id="size" step="0.01" min="0">
                <small class="form-text text-muted">Please, provide size in MB</small>
            </div>

            <!-- Book Specific Field -->
            <div id="bookFields" class="hidden mb-3">
                <label for="weight" class="form-label">Weight (KG)</label>
                <input type="number" class="form-control" id="weight" step="0.01" min="0">
                <small class="form-text text-muted">Please, provide weight in KG</small>
            </div>

            <!-- Furniture Specific Fields -->
            <div id="furnitureFields" class="hidden mb-3">
                <label for="height" class="form-label">Height (CM)</label>
                <input type="number" class="form-control" id="height" step="0.01" min="0">
                <label for="width" class="form-label">Width (CM)</label>
                <input type="number" class="form-control" id="width" step="0.01" min="0">
                <label for="length" class="form-label">Length (CM)</label>
                <input type="number" class="form-control" id="length" step="0.01" min="0">
                <small class="form-text text-muted">Please, provide dimensions in HxWxL format</small>
            </div>

            <div id="errorMessage" class="error hidden">Please, submit required data</div>
        </form>
    </div>
    <?php include __DIR__ . '/Partials/footer.php'; ?>

  
        <script src="../public/js//bootstrap.bundle.min.js"></script>

    <script src="../public/js/jquery.min.js"></script>


  
  
  
  
  
    <script src="../public/js/add-product.js"></script>
</body>

</html>