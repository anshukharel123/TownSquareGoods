<?php
function fetchTraders() {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT PRODUCT_ID, PRODUCT_NAME, PRODUCT_DESCRIPTION, PRODUCT_IMAGE, QUANTITY_IN_STOCK, PRICE, IS_DISABLED, UNIT, ALERGYINFORMATION, SHOP_ID FROM townsquare.product";

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

    // Fetch the results and group by SHOP_ID
    $traders = [];
    while ($row = oci_fetch_assoc($statement)) {
        $traders[$row['SHOP_ID']][] = $row;
    }

    // Close the database connection
    oci_close($connection);

    return $traders;
}
?>
