<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRADER</title>
    <link rel="stylesheet" type="text/css" href="../all-traders/all-traders.css">
</head>

<body>
    <?php 
    include __DIR__ . '/../header/header.php'; 
    include __DIR__ . '/../database/fetch_all_traders.php';
    include __DIR__ . '/../database/shop_request.php';

    $tradersByShop = fetchTraders();
    $shops = fetchShops();

    // Get the selected shop ID from the URL or form submission
    $selectedShopId = isset($_GET['shop_id']) ? $_GET['shop_id'] : null;

    // Get selected categories from the form
    $selectedCategories = isset($_GET['Category']) ? $_GET['Category'] : [];

    // Create an associative array with shop ID as key and shop name as value
    $shopNames = [];
    foreach ($shops as $shop) {
        $shopNames[$shop['SHOP_REQUEST_ID']] = $shop['SHOP_NAME'];
    }
    ?>

    <div class="page filter-page">
        <div class="container page__body">
            <div class="filter-result-container">
                <div class="filter-result-container__left">
                    <div class="Categories-filter-page">
                        <div class="Categories-filter-page__Header">
                            Type of Category
                        </div>
                        <form class="Categories-filter-page__Form" method="GET">
                            <?php
                            foreach ($shops as $shop) {
                                $shopId = $shop['SHOP_REQUEST_ID'];
                                $shopName = $shop['SHOP_NAME'];
                                if (!isset($tradersByShop[$shopId])) {
                                    continue;
                                }
                                $checked = in_array($shopName, $selectedCategories) || $selectedShopId == $shopId ? 'checked' : '';
                                echo '<div class="category-checkbox">';
                                echo '<input type="checkbox" value="' . htmlspecialchars($shopName) . '" name="Category[]" ' . $checked . '>';
                                echo '<label for="Categories-' . htmlspecialchars($shopId) . '">' . ucfirst(htmlspecialchars($shopName)) . '</label>';
                                echo '</div>';
                            }
                            ?>
                            <input type="submit" value="Apply" class="btn primary-outline-btn">
                        </form>
                    </div>
                </div>
                <div class="filter-result-container__right">
                    <?php 
                    foreach ($shops as $shop) {
                        $shopId = $shop['SHOP_REQUEST_ID'];
                        $shopName = $shop['SHOP_NAME'];

                        // Check if the current shop is selected either via URL or form submission
                        if (in_array($shopName, $selectedCategories) || $selectedShopId == $shopId) {
                            if (!isset($tradersByShop[$shopId])) {
                                continue;
                            }
                    ?>
                        <div class="title">
                            <div class="text"><?php echo htmlspecialchars($shopName); ?></div>
                        </div>

                        <div class="category">
                            <?php foreach ($tradersByShop[$shopId] as $trader) { ?>
                                <div class="product">
                                    <img class="image" src="../pictures/<?php echo htmlspecialchars($trader['PRODUCT_IMAGE']); ?>" alt="<?php echo htmlspecialchars($trader['PRODUCT_NAME']); ?>">
                                    <p><?php echo htmlspecialchars($trader['PRODUCT_NAME']); ?></p>
                                    <p><?php echo htmlspecialchars($trader['PRICE']); ?></p>
                                    <div class="buttons">
                                        <button class="view-button">ADD TO CART</button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php 
                        }
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../footer/footer.php'; ?>
</body>

<script src="app.js"></script>

</html>
