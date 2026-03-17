<?php
session_start();
include __DIR__ . '/../database/connection.php';
include __DIR__ . '/../database/fetch_users.php';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Initialize database connection
    $conn = oci_connect('townsquare', 'townsquare', 'localhost/XE');

    if (!$conn) {
        $error_message = "Failed to connect to the database.";
    } else {
        // Fetch user by email
        $user = fetchUserByEmail($email, $conn);

        if ($user) {
            // Check if the new password matches the confirm password
            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Update password in the database
                $updateSql = "UPDATE USERS SET PASSWORD = :password WHERE EMAIL = :email";
                $stmt = oci_parse($conn, $updateSql);
                oci_bind_by_name($stmt, ':password', $hashed_password);
                oci_bind_by_name($stmt, ':email', $email);
                $result = oci_execute($stmt);

                if ($result) {
                    oci_commit($conn); // Commit changes
                    // Show success message and redirect to login page
                    echo '<script>alert("Password has been changed successfully.");</script>';
                    echo '<script>window.location.href = "../login/login.php";</script>';
                    exit();
                } else {
                    $error_message = "Failed to update password: " . oci_error($stmt)['message'];
                }
            } else {
                $error_message = "New password and confirm password do not match.";
            }
        } else {
            $error_message = "User with the provided email does not exist.";
        }

        oci_close($conn); // Close database connection
    }
}

function fetchUserByEmail($email, $conn) {
    // Fetch user by email from the database
    $query = "SELECT * FROM USERS WHERE EMAIL = :email";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':email', $email);
    oci_execute($stmt);
    $user = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);
    return $user;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="login.css">
    <!-- Link Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form id="forgotPasswordForm" method="post" action="">
        <h3>Forgot Password</h3>
        <div class="input-container">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-container">
            <label for="new_password">New Password</label>
            <input type="password" placeholder="New Password" id="new_password" name="new_password" required>
        </div>
        <div class="input-container">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit">Reset Password</button>
        <div class="links">
            <a href="../login/login.php">Back to Login</a>
        </div>
        <?php if (!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
    </form>
</body>
</html>
