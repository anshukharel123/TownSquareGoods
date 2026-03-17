<?php
session_start();
include __DIR__ . '/../database/fetch_data.php';
include __DIR__ . '/../database/connection.php';

$userId = $_SESSION['user_id'];
$products = $wishlist->getWishlistProducts($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link rel="stylesheet" href="wishlist.css">
</head>
<body>
    <div class="wishlist-container">
        <h1>My Wishlist</h1>
        <ul class="wishlist">
            <?php foreach ($products as $product): ?>
                <li class="wishlist-item">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="product-details">
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                        <p>$<?php echo htmlspecialchars($product['price']); ?></p>
                        <form method="post" action="wishlist_operations.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="remove" class="remove-button">Remove</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
