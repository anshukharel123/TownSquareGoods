<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve product ID and quantity from the form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Add product to cart list
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // If product is already in the cart, update the quantity
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // If product is not in the cart, add it with the specified quantity
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // JavaScript to display a pop-up alert
    echo '<script>alert("Product added to cart successfully.");</script>';

    // You can also choose to provide an option to continue shopping or go to the cart
    // Example:
    echo '<script>window.location.href = "product_detail.php?product_id=' . $product_id . '";</script>';
}
?>
