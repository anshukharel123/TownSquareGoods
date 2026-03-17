<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="register.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>
<body>
    
<?php include __DIR__ . '/../header/header.php'; ?><br><br>

<section class="signupsection">
    <div class="signup-container">
        <h2>Create Your Account</h2>

        <?php
        session_start();
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;

        require 'C:/xampp/htdocs/TSgoods/PHPMailer-master/src/Exception.php';
        require 'C:/xampp/htdocs/TSgoods/PHPMailer-master/src/PHPMailer.php';
        require 'C:/xampp/htdocs/TSgoods/PHPMailer-master/src/SMTP.php';

        $error_message = '';
        $success_message = '';

        // Reestablish the connection
        $conn = oci_connect('townsquare', 'townsquare', 'localhost/XE');

        if (!$conn) {
            $error_message = "Failed to establish database connection.";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Capture form data
            $firstname = $_POST['first-name'];
            $lastname = $_POST['last-name'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];
            $contact_number = $_POST['phone_number'];
            $role = $_POST['register-as'];

            // Validate passwords match
            if ($password !== $confirm_password) {
                $error_message = "Passwords do not match.";
            } else {
                // Hash the password
                $hashed_password = md5($password);
                // Insert data into the database
                $sql = 'INSERT INTO "USERS" (USER_ID, USERNAME, EMAIL, PASSWORD, PHONE_NO, GENDER, USER_ROLE)
                        VALUES (USER_SEQ.NEXTVAL, :username, :email, :password, :phone_no, :gender, :role)';

                $stmt = oci_parse($conn, $sql);

                if (!$stmt) {
                    $e = oci_error($conn);
                    $error_message = "SQL parsing error: " . $e['message'];
                    exit;
                }

                // Bind parameters
                $username = $firstname . $lastname; // Combine first name and last name
                oci_bind_by_name($stmt, ':username', $username);
                oci_bind_by_name($stmt, ':email', $email);
                oci_bind_by_name($stmt, ':password', $hashed_password);
                oci_bind_by_name($stmt, ':phone_no', $contact_number);
                oci_bind_by_name($stmt, ':gender', $gender);
                oci_bind_by_name($stmt, ':role', $role);

                // Execute the statement
                if (oci_execute($stmt)) {
                    $success_message = "User registered successfully.";

                    // Send confirmation email
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
                        $mail->isSMTP();                                    // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';               // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                           // Enable SMTP authentication
                        $mail->Username   = 'townsquaregoods00@gmail.com';  // SMTP username
                        $mail->Password   = 'zzte ztng uliw qibp';          // App-specific password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                        $mail->Port       = 587;                            // TCP port to connect to

                        // Recipients
                        $mail->setFrom('townsquaregoods00@gmail.com', 'TownSquare Goods');
                        $mail->addAddress($email, $firstname . ' ' . $lastname); // Recipient's email and name

                        // Content
                        $mail->isHTML(true);                                // Set email format to HTML
                        $mail->Subject = 'Registration Successful';
                        $mail->Body    = 'Dear ' . $firstname . ',<br><br>Thank you for registering at TownSquare Goods.<br><br>Best Regards,<br>TownSquare Goods Team';

                        // Send the email
                        $mail->send();
                    } catch (Exception $e) {
                        $error_message = "User registered successfully but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                    echo '<script>window.location.href = "http://localhost/TSgoods/login/login.php";</script>';
                } else {
                    $e = oci_error($stmt);
                    $error_message = "Error registering user: " . $e['message'];
                }

                // Close the statement
                oci_free_statement($stmt);
            }

            // Close the connection
            oci_close($conn);
        }
        ?>

        <form action="" method="post">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first-name" required>

            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last-name" required>

            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <label for="contact-number">Contact Number</label>
            <input type="text" id="contact-number" name="phone_number" required>

            <label for="register-as">Register as</label>
            <select id="register-as" name="register-as" required>
                <option value="customer">Customer</option>
                <option value="trader">Trader</option>
            </select>

            <div class="terms">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I hereby agree to the terms and conditions.</label>
            </div>

            <button type="submit">Agree and Register</button>
        </form>
    </div>
</section><br><br>
<?php include __DIR__ . '/../footer/footer.php'; ?>
</body>
</html>
