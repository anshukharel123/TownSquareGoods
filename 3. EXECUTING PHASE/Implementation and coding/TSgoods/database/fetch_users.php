<?php
function fetchUsers($schema = "townsquare") {
    // Establish a database connection
    $connection = oci_connect("townsquare", "townsquare", "localhost/XE");

    // Check if the connection was successful
    if (!$connection) {
        $error = oci_error();
        return ["error" => "Failed to connect to the database: " . $error['message']];
    }

    // Define the SQL query with the correct schema name
    $query = "SELECT USER_ID, USERNAME, EMAIL, PASSWORD, PHONE_NO, GENDER, USER_ROLE FROM $schema.users";

    // Parse the SQL query
    $statement = oci_parse($connection, $query);

    // Execute the SQL query
    $success = oci_execute($statement);

    // Check if the query was executed successfully
    if (!$success) {
        $error = oci_error($statement);
        oci_close($connection);
        return ["error" => "Failed to execute the query: " . $error['message']];
    }

    // Fetch the results
    $users = [];
    while ($row = oci_fetch_assoc($statement)) {
        $users[] = $row;
    }

    // Close the database connection
    oci_close($connection);

    return $users;
}
?>
