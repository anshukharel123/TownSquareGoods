<?php
function fetchShops() {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT SHOP_REQUEST_ID,SHOP_ADDRESS, SHOP_NAME,SHOP_CONTACT,CATEGORY, SHOP_DESCRIPTION,PROPOSAL_MESSAGE, IS_APPROVED, USER_ID, SHOP_IMAGE FROM townsquare.shop_request";

    // Parse the SQL query
    $statement = oci_parse($connection, $query);

    // Execute the SQL query
    $success = oci_execute($statement);

    // Check if the query was executed successfully
    if (!$success) {
        $error = oci_error($statement);
        echo "Failed to execute the query: " . $error['message'];
        oci_close($connection);
        return [];
    }

    // Fetch the results
    $shops = [];
    while ($row = oci_fetch_assoc($statement)) {
        $shops[] = $row;
    }

    // Close the database connection
    oci_close($connection);

    return $shops;
}
?>