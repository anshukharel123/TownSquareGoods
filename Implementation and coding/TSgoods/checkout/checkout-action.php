<?php
session_start();
include __DIR__ . '/../database/connection.php';

$response = array('success' => false, 'message' => '', 'data' => array());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
    $action = isset($data['action']) ? $data['action'] : 'add';  // Default action is 'add'
    $stock = isset($data['stock']) ? intval($data['stock']) : 0;

    if ($product_id <= 0) {
        $response['message'] = 'Invalid product ID.';
    } else {
        if (!isset($_SESSION['user_id'])) {
            $response['message'] = 'User not logged in.';
        } else {
            $user_id = $_SESSION['user_id'];

            // Reestablish the connection
            $conn = oci_connect('townsquare', 'townsquare', 'localhost/XE');
            if (!$conn) {
                $response['message'] = "Failed to establish database connection.";
            } else {
                // Get the cart ID
                $cart_query = "SELECT CARTLIST_ID FROM CARTLIST WHERE USER_ID = :user_id";
                $cart_stmt = oci_parse($conn, $cart_query);
                oci_bind_by_name($cart_stmt, ':user_id', $user_id);
                oci_execute($cart_stmt);
                $cart_row = oci_fetch_assoc($cart_stmt);
                $cart_id = $cart_row['CARTLIST_ID'];

                if (!$cart_id) {
                    // Create a new cart for the user if it doesn't exist
                    $cart_id = rand(10000000, 99999999); // Replace with a proper method to generate unique IDs
                    $insert_cart_query = "INSERT INTO CARTLIST (CARTLIST_ID, USER_ID) VALUES (:cart_id, :user_id)";
                    $insert_cart_stmt = oci_parse($conn, $insert_cart_query);
                    oci_bind_by_name($insert_cart_stmt, ':cart_id', $cart_id);
                    oci_bind_by_name($insert_cart_stmt, ':user_id', $user_id);
                    oci_execute($insert_cart_stmt);
                }

                if ($action === 'add') {
                    // Increment the quantity of the product in the cart
                    // You need to implement this part based on your database structure
                } elseif ($action === 'remove') {
                    // Remove the product from the cart
                    // You need to implement this part based on your database structure
                }

                // Close the database connection
                oci_close($conn);
            }
        }
    }
}

echo json_encode($response);
?>
