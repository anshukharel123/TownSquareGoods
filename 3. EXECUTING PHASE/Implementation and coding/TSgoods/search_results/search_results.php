<?php
// Include the database connection and fetch data functions
include __DIR__ . '/../database/fetch_data.php';

// Handle the search query
$searchQuery = "";
$products = [];
if (isset($_GET['search'])) {
    $searchQuery = htmlspecialchars($_GET['search']);
    $products = searchProducts($searchQuery);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include __DIR__ . '/../header/header.php'; ?><br>

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="d-flex justify-content-center">
                <h3 class="mb-3 text-center py-1 text-white px-5" style="background-color: #D1BB9E; border-radius: 40px;">Search Results</h3>
            </div>
            <div class="row">
                <?php if (empty($products)): ?>
                    <p>No products found.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4">
                            <a href="../product-detail/product_detail.php?id=<?php echo htmlspecialchars($product['PRODUCT_ID']); ?>">
                                <div class="card mb-3">
                                    <img src="../pictures/<?php echo htmlspecialchars($product['PRODUCT_IMAGE']); ?>" class="card-img-top" alt="Product Image" style="height:300px; width: 100%; object-fit: contain;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?></h5>
                                        <p class="card-text">Price: $<?php echo htmlspecialchars($product['PRICE']); ?></p>
                                        <p class="card-text"><?php echo htmlspecialchars($product['PRODUCT_DESCRIPTION']); ?></p>
                                        <div class="buttons-cart">
                                            <button class="btn btn-primary" id="add-to-cart">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../footer/footer.php'; ?>
</body>

</html>
