<?php
session_start();

// Reestablish the connection
$conn = oci_connect('townsquare', 'townsquare', 'localhost/XE');

if (!$conn) {
    die("Failed to establish database connection.");
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = 'SELECT * FROM "USERS" WHERE VERIFICATION_TOKEN = :token AND VERIFIED = 0';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':token', $token);
    oci_execute($stmt);

    if ($row = oci_fetch_assoc($stmt)) {
        $sql_update = 'UPDATE "USERS" SET VERIFIED = 1 WHERE VERIFICATION_TOKEN = :token';
        $stmt_update = oci_parse($conn, $sql_update);
        oci_bind_by_name($stmt_update, ':token', $token);
        oci_execute($stmt_update);

        echo "Your email has been verified successfully. You can now <a href='http://localhost/TSgoods/login/login.php'>login</a>.";
    } else {
        echo "This token is invalid or the email is already verified.";
    }

    oci_free_statement($stmt);
    oci_free_statement($stmt_update);
} else {
    echo "No token provided.";
}

// Close the connection
oci_close($conn);
?>
