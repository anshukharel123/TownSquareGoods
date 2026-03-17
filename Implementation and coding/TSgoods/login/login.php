<?php
    session_start();
    include __DIR__ . '/../database/fetch_users.php'; // Make sure this file includes OCI8 connection setup

    $error_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Assuming passwords are stored as MD5 hashes
        $user_role = $_POST['user_role'];

        // Fetch users from the database
        $users = fetchUsers();

        // Check if the user exists and their role matches
        $user = null;
        foreach ($users as $u) {
            if ($u['EMAIL'] === $email && $u['PASSWORD'] === $password && $u['USER_ROLE'] === $user_role) {
                $user = $u;
                break;
            }
        }

        if ($user) {
            $_SESSION['user'] = $user;

            // Redirect based on user role
            if ($user_role === 'customer') {
                echo '<script>window.location.href = "../homepage/homepage.php";</script>';
                exit();
            } elseif ($user_role === 'admin') {
                echo '<script>window.location.href = "../dashboard/admin.php";</script>';
                exit();
            } elseif ($user_role === 'trader') {
                echo '<script>window.location.href = "../dashboard/trader.php";</script>';
                exit();
            }
        } else {
            // Invalid credentials, display error message
            $error_message = "Invalid email, password, or role.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <form id="loginForm" method="post" action="">
        <h3>Login Here</h3>
        <div class="input-container">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-container">
            <label for="password">Password</label>
            <div class="password-input-container">
                <input type="password" placeholder="Password" id="password" name="password" required>
                <i class="fas fa-eye-slash toggle-password"></i>
            </div>
        </div>

        <label for="user_role">Login As:</label>
        <select id="user_role" name="user_role" required>
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
            <option value="trader">Trader</option>
        </select>
        <button type="submit">Log In</button>
        <div class="links">
            <a href="forgot_password.php">Forgot Password?</a>
            <a href="../register/register.php">Sign Up</a>
        </div>
    </form>

    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('input[type="password"]');
    
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Toggle the eye icon classes
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Check for error message and display alert
        <?php if (!empty($error_message)) { ?>
            alert("<?php echo $error_message; ?>");
        <?php } ?>
    </script>
</body>
</html>
