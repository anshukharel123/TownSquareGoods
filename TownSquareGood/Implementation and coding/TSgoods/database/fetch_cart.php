<?php
function fetchCollection() {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT COLLECTION_ID, DAY, TIMESLOT, DATE_OF_COLLECTION, ORDERPLACE_ID FROM townsquare.collection_slot";

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

function fetchCart() {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT CARTLIST_ID, QUANTITY, PRODUCT_ID, USER_ID FROM townsquare.cartlist";

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

function fetchOrderlist() {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT ORDERLIST_ID, QUANTITY, ORDERPLACE_ID, PRODUCT_ID FROM townsquare.orderlist";

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

function fetchWishlist() {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT WISHLIST_ID, ADDED_AT, USER_ID, PRODUCT_ID FROM townsquare.wishlist";

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

function fetchReview() {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        echo "Failed to connect to the database: " . $error['message'];
        return [];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT REVIEW_ID, MESSAGE, NO_OF_STARS, PRODUCT_ID, USER_ID FROM townsquare.review";

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