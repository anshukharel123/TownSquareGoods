<!DOCTYPE html>
<html lang="en">
<head>
    <title>TRADER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../trader/traders.css">
</head>
<body>

<?php 
include __DIR__ . '/../header/header.php'; 
include __DIR__ . '/../database/shop_request.php'; // Include the fetch shops file

$allShops = fetchShops();
?>

<div class="banner">
    <img class="img" src="../images/banner.png" width="30%">
</div>

<div class="title">
    <div class="text">CATEGORIES</div>
</div>

<div class="category">
    <?php foreach ($allShops as $shop) { ?>
        <div class="container">
            <div class="product">
                <img class="image" src="../images/<?php echo isset($shop['SHOP_IMAGE']) ? htmlspecialchars($shop['SHOP_IMAGE']) : 'default_image.jpg'; ?>" alt="<?php echo isset($shop['SHOP_NAME']) ? htmlspecialchars($shop['SHOP_NAME']) : 'Shop Name'; ?>">
                <p class="name"><?php echo isset($shop['SHOP_NAME']) ? htmlspecialchars($shop['SHOP_NAME']) : 'Shop Name'; ?></p>
                <p class="des"><?php echo isset($shop['SHOP_DESCRIPTION']) ? htmlspecialchars($shop['SHOP_DESCRIPTION']) : 'Description'; ?></p>
                <div class="buttons">
                    <a href="../all-traders/all-traders.php?shop_id=<?php echo $shop['SHOP_REQUEST_ID']; ?>">
                        <button class="view-button">VIEW</button>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php include __DIR__ . '/../footer/footer.php'; ?>

</body>
</html>
