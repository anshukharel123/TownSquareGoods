<!DOCTYPE html>
<html lang="en">
<head>
    <title>TRADER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../header/header.css">
</head>
<body>
    <div class="navigation">
        <div class="opt">
            <div class="left">
                <img class="menu" src="../images/list.png" alt="Menu">
                <a href="../homepage/homepage.php">
                    <img class="logo" src="../images/TSlogo.jpg" alt="Logo">
                </a>

            </div>
            <div class="middle">
                <div class="search">
                    <form method="GET" action="../search_results/search_results.php">
                        <input class="searchbar" type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit" style="background: none; border: none;">
                            <img class="menu" src="../images/search.png" alt="Search">
                        </button>
                    </form>
                </div>
            </div>
            <div class="right">
            <a href="../checkout/checkout.php">
                <img class="menu" src="../images/cart.jpeg" alt="Cart">
            </a>
                <img class="menu" src="../images/account.webp" alt="Account">
            </div>
        </div>
    </div>
</body>
</html>
