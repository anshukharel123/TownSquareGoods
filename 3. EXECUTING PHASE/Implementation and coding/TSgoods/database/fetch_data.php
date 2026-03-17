<?php

function fetchTraders() {
    $connection = oci_connect('townsquare', 'townsquare', '//localhost/xe');
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }
    $query = "SELECT PRODUCT_ID, PRODUCT_NAME, PRODUCT_DESCRIPTION, PRODUCT_IMAGE, QUANTITY_IN_STOCK, PRICE, IS_DISABLED, UNIT, ALERGYINFORMATION, SHOP_ID FROM product";
    $statement = oci_parse($connection, $query);
    $success = oci_execute($statement);
    if (!$success) {
        $error = oci_error($statement);
        echo "Failed to execute the query: " . $error['message'];
        oci_close($connection);
        return [];
    }
    $traders = [];
    while ($row = oci_fetch_assoc($statement)) {
        $traders[$row['SHOP_ID']][] = $row;
    }
    oci_close($connection);
    return $traders;
}

function fetchShops() {
    $connection = oci_connect('townsquare', 'townsquare', '//localhost/xe');
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }
    $query = "SELECT SHOP_REQUEST_ID, SHOP_ADDRESS, SHOP_NAME, SHOP_CONTACT, CATEGORY, SHOP_DESCRIPTION, PROPOSAL_MESSAGE, IS_APPROVED, USER_ID, SHOP_IMAGE FROM shop_request";
    $statement = oci_parse($connection, $query);
    $success = oci_execute($statement);
    if (!$success) {
        $error = oci_error($statement);
        echo "Failed to execute the query: " . $error['message'];
        oci_close($connection);
        return [];
    }
    $shops = [];
    while ($row = oci_fetch_assoc($statement)) {
        $shops[] = $row;
    }
    oci_close($connection);
    return $shops;
}

function searchProducts($searchQuery) {
    $connection = oci_connect('townsquare', 'townsquare', '//localhost/xe');
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }
    $query = "SELECT * FROM product WHERE LOWER(product_name) LIKE '%' || LOWER(:search) || '%' OR LOWER(product_description) LIKE '%' || LOWER(:search) || '%'";
    $statement = oci_parse($connection, $query);
    oci_bind_by_name($statement, ':search', $searchQuery);
    $success = oci_execute($statement);
    if (!$success) {
        $error = oci_error($statement);
        echo "Failed to execute the query: " . $error['message'];
        oci_close($connection);
        return [];
    }
    $products = [];
    while ($row = oci_fetch_assoc($statement)) {
        $products[] = $row;
    }
    oci_close($connection);
    return $products;
}

// Function to retrieve shop details including the image
function getShopDetails($shopId) {
    global $conn;
    $query = "SELECT SHOP_NAME, SHOP_IMAGE FROM SHOP_REQUEST 
              INNER JOIN SHOP ON SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID
              WHERE SHOP.SHOP_ID = :shopId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':shopId', $shopId);
    oci_execute($stmt);
    return oci_fetch_array($stmt);
}

function fetchWhishlist(){
    $connection = oci_connect('townsquare', 'townsquare', '//localhost/xe');
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }
    $query = "SELECT WISHLIST_ID, ADDED_AT, USER_ID, PRODUCT_ID FROM wishlist";
    $statement = oci_parse($connection, $query);
    $success = oci_execute($statement);
    if (!$success) {
        $error = oci_error($statement);
        echo "Failed to execute the query: " . $error['message'];
        oci_close($connection);
        return [];
    }
    $wishlist = [];
    while ($row = oci_fetch_assoc($statement)) {
        $wishlist[] = $row;
    }
    oci_close($connection);
    return $wishlist;
}

?>
