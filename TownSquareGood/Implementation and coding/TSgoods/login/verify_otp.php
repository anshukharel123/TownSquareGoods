<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>
<body>
    <form action="verify_otp.php" method="post">
        <fieldset>
            <legend><h2>Verify OTP</h2></legend>
            <label>Enter OTP</label>
            <input type="text" name="otp" placeholder="Enter the OTP sent to your email" required><br><br>
            <input type="submit" value="Verify OTP" name="verify_otp">
        </fieldset>
    </form>

    <?php 
    session_start();

    if (isset($_POST['verify_otp'])) {
        $entered_otp = $_POST['otp'];

        if ($entered_otp == $_SESSION['otp']) {
            include __DIR__ . '/../database/connection.php';

            $email = $_SESSION['re_email'];
            $new_password = $_SESSION['new_password'];

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("UPDATE email SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $new_password, $email);

            if ($stmt->execute()) {
                // Clear session variables
                unset($_SESSION['otp']);
                unset($_SESSION['new_password']);
                
                header("Location: homepage.php");
                exit();
            } else {
                echo "Password could not be reset. Please try again.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Invalid OTP. Please try again.";
        }
    }
    ?>
</body>
</html>
