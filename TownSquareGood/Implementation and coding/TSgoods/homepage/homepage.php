<?php
// Include the database connection and fetch data functions
include __DIR__ . '/../database/fetch_data.php';

// Handle the search query
$searchQuery = "";
$products = [];
if (isset($_GET['search'])) {
    $searchQuery = htmlspecialchars($_GET['search']);
    $products = searchProducts($searchQuery);
} else {
    // If no search query, fetch all products (or some default behavior)
    $products = fetchTraders(); // Adjust this if needed
}

// Fetch traders and shops data
$traders = fetchTraders();
$shops = fetchShops();

// Initialize $quantity_in_stock with a default value
$quantity_in_stock = 0;

// Getting Product and Shop Details
if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    
    $query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':id', $id);
    oci_execute($stmt);
    $row = oci_fetch_array($stmt);

    // Assign the quantity in stock to the variable
    $quantity_in_stock = $row['QUANTITY_IN_STOCK'];

    $query2 = "SELECT SHOP_NAME, SHOP_IMAGE 
            FROM SHOP_REQUEST
            INNER JOIN SHOP ON SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID
            WHERE SHOP.SHOP_ID = :shopId";
    $stmt2 = oci_parse($conn, $query2);
    oci_bind_by_name($stmt2, ':shopId', $row['SHOP_ID']);
    oci_execute($stmt2);
    $shop = oci_fetch_array($stmt2);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</head>

<body>
<?php include __DIR__ . '/../header/header.php'; ?>
<div class="banner-container">
    <img src="../images/banner.png" alt="banner" class="banner">
    <div class="text-container">
        <h1>TownSquareGoods</h1>
        <p>"Your Local Marketplace, Where Community and Convenience Meet!"</p>
    </div>
</div>



<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="mb-3" id="shop">CATEGORY</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 position-relative">
                <div class="carousel-control-prev-wrapper">
                    <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                </div>
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $chunks = array_chunk($shops, 3);
                        foreach ($chunks as $index => $chunk) {
                            $activeClass = $index === 0 ? 'active' : '';
                            echo "<div class='carousel-item $activeClass'><div class='row'>";
                            foreach ($chunk as $shop) {
                                echo "
                                <div class='col-md-4 mb-3'>
                                    <div class='card-container'>
                                        <div class='card'>
                                            <img class='img-fluid' alt='" . htmlspecialchars($shop['SHOP_NAME']) . "' src='../images/" . htmlspecialchars($shop['SHOP_IMAGE']) . "' />
                                            <div class='card-body'>
                                                <h4 class='card-title'>" . htmlspecialchars($shop['SHOP_NAME']) . "</h4>
                                                <p class='card-text'>" . htmlspecialchars($shop['SHOP_DESCRIPTION']) . "</p>
                                                <button class='view' onclick='navigateToShopProducts({$shop['SHOP_REQUEST_ID']})'>VIEW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
                            echo "</div></div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="carousel-control-next-wrapper">
                    <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="mb-3" id="shop">Shop Products Slider</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 position-relative">
                <div class="carousel-control-prev-wrapper">
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $chunks = array_chunk($traders, 3);
                        foreach ($chunks as $index => $chunk) {
                            $activeClass = $index === 0 ? 'active' : '';
                            echo "<div class='carousel-item $activeClass'><div class='row'>";
                            $count = 0;
                            foreach ($chunk as $shopId => $products) {
                                foreach ($products as $product) {
                                    if ($count < 3) {
                                        echo "
                                        <div class='col-md-4 mb-3'>
                                            <a href='../product-detail/product_detail.php?product_id={$product['PRODUCT_ID']}' class='card-link'>
                                                <div class='card'>
                                                    <img src='../pictures/" . htmlspecialchars($product['PRODUCT_IMAGE']) . "' class='card-img-top' alt='" . htmlspecialchars($product['PRODUCT_NAME']) . "' style='height: 200px; width: 100%; object-fit: contain;'>
                                                    <div class='card-body text-black'> <!-- Added text-black class -->
                                                        <h4 class='card-title'>" . htmlspecialchars($product['PRODUCT_NAME']) . "</h4>
                                                        <p class='card-text'>" . htmlspecialchars($product['PRODUCT_DESCRIPTION']) . "</p>
                                                        <p class='card-text'>Price: $" . htmlspecialchars($product['PRICE']) . "</p>
                                                        <p class='card-text'>In Stock: " . htmlspecialchars($product['QUANTITY_IN_STOCK']) . "</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>";
                                        $count++;
                                    } else {
                                        break;
                                    }
                                }
                            }
                            echo "</div></div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="carousel-control-next-wrapper">
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-5 pb-5">
    <div class="container">
        <div class="col-6">
            <h3 class="mb-3" id="shop">Products</h3>
        </div>
        <div class="row">
            <?php if (empty($products)): ?>
                <p>No products found.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="../pictures/<?php echo htmlspecialchars($product['PRODUCT_IMAGE']); ?>" class="card-img-top" alt="Product Image" style="height:300px; width: 100%; object-fit: contain;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?></h5>
                                <p class="card-text">Price: $<?php echo htmlspecialchars($product['PRICE']); ?></p>
                                <form method="POST" action="add_to_cart.php"> <!-- Change the action to add_to_cart.php or any other appropriate script -->
                                    <input type="hidden" name="product_id" value="<?php echo $id ?>">
                                    <input type="hidden" name="quantity" value="<?php echo $qty ?>">
                                    <button class="button" type="submit" name="add-product" <?php if ($quantity_in_stock <= 0) echo "disabled"; ?>>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                addToCart(productId);
            });
        });

        function addToCart(productId) {
            const data = new URLSearchParams();
            data.append('product_id', productId);
            data.append('quantity', 1); // Assuming adding 1 quantity for each click
            data.append('type', 'add'); // Indicate the action as "add" to the cart

            fetch('checkout.php', {
                method: 'POST',
                body: data
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                console.log('Product added to cart:', productId);
                // You can handle any additional UI updates or notifications here
            })
            .catch(error => {
                console.error('Error adding product to cart:', error.message);
                // You can handle error cases here, such as displaying an alert to the user
            });
        }
    });
</script>

<?php include __DIR__ . '/../footer/footer.php'; ?>

<script>
    function navigateToShop(shopId) {
        window.location.href = '../all-traders/all-traders.php?shop_id=' + shopId;
    }

    function navigateToShopProducts(shopId) {
        window.location.href = '../all-traders/all-traders.php?shop_id=' + shopId;
    }
</script>

</body>

</html>
