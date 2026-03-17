<?php
session_start();
$conn = oci_connect('townsquare', 'townsquare', 'localhost/XE');

// Check connection
if (!$conn) {
    $error = oci_error();
    trigger_error(htmlentities($error['message'], ENT_QUOTES), E_USER_ERROR);
}

include __DIR__ . '/../database/connection.php';

// Initialize variables
$row = null;
$row2 = null;

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];

    $query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID=" . $id;
    $result = oci_parse($conn, $query);
    oci_execute($result);
    $row = oci_fetch_array($result);

    $query2 = "SELECT SHOP_NAME 
                FROM SHOP_REQUEST
                INNER JOIN
                SHOP ON 
                SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID
                WHERE SHOP.SHOP_ID =" . $row['SHOP_ID'];
    $result2 = oci_parse($conn, $query2);
    oci_execute($result2);
    $row2 = oci_fetch_array($result2);
}

// Checking if item is in stock
$fetchquantityinStockSql2 = "SELECT QUANTITY_IN_STOCK FROM PRODUCT WHERE PRODUCT_ID = :id";
$stidNew2 = oci_parse($conn, $fetchquantityinStockSql2);
oci_bind_by_name($stidNew2, ':id', $id);
oci_execute($stidNew2);
$rowStock = oci_fetch_array($stidNew2, OCI_ASSOC);

$qty_in_stock_check = $rowStock['QUANTITY_IN_STOCK'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = false;
}

// Adding product to cart
if (isset($_POST['add-product'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // To validate.... check if quantity is int>0, product is in table
    if ($quantity > 0 && filter_var($quantity, FILTER_VALIDATE_INT) && $quantity <= 20) {

        // We will be checking the stock availability from the database.
        $fetchquantityinStockSql = "SELECT QUANTITY_IN_STOCK FROM PRODUCT WHERE PRODUCT_ID = $product_id";

        $stidNew = oci_parse($conn, $fetchquantityinStockSql);
        oci_execute($stidNew);

        while (oci_fetch($stidNew)) {
            $qty_in_stock = oci_result($stidNew, 'QUANTITY_IN_STOCK');
        }

        $currentItemInCart = 0;
        if (isset($_SESSION['cart'][$product_id])) {
            $currentItemInCart = $_SESSION['cart'][$product_id];
        }

        // We have fetched the current quantity of the item in our cart and the quantity total in stock.
        // Users should not be able to keep items in the cart more than it is in stock.

        if ($qty_in_stock < $currentItemInCart) {
            // If the item in stock is equal to the item in the cart, the user should not be able to add more.
            echo "<script>alert('You have already kept $qty_in_stock of it in your cart for this product. ITEM OUT OF STOCK!')</script>";
        } elseif ($qty_in_stock + 1 <= ($currentItemInCart + $quantity)) {
            echo "<script>alert('There are only $qty_in_stock left in stock, You have $currentItemInCart in your cart. Cannot add to cart')</script>";
        } else {
            if (isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']) {
                $user_id = $_SESSION['user_id'];

                $sqlCheckIfAlreadyICart = "SELECT PRODUCT_ID,QUANTITY FROM CARTLIST WHERE USER_ID=:user_id AND PRODUCT_ID=:product_id";
                $stidCheckIfAlreadyICart = oci_parse($conn, $sqlCheckIfAlreadyICart);
                oci_bind_by_name($stidCheckIfAlreadyICart, ':user_id', $user_id);
                oci_bind_by_name($stidCheckIfAlreadyICart, ':product_id', $product_id);
                oci_execute($stidCheckIfAlreadyICart);

                while (($row = oci_fetch_object($stidCheckIfAlreadyICart)) != false) {
                    $isProductAlreadyPresent = $row->PRODUCT_ID;
                    $currentQuantity = $row->QUANTITY;
                }

                if (isset($isProductAlreadyPresent) && $isProductAlreadyPresent) {
                    // Update quantity
                    $sqlUpdateCart = "UPDATE CARTLIST 
                                        SET quantity=:quantity
                                        WHERE USER_ID=$user_id AND PRODUCT_ID=$product_id";

                    $stidUpdateCart  = oci_parse($conn, $sqlUpdateCart);
                    $tempQuantity = $quantity + $currentQuantity;
                    oci_bind_by_name($stidUpdateCart, ':quantity', $tempQuantity);
                    oci_execute($stidUpdateCart, OCI_COMMIT_ON_SUCCESS);
                } else {
                    // Else insert
                    $sqlInsertCart = "INSERT INTO CARTLIST(USER_ID,PRODUCT_ID,QUANTITY) VALUES ($user_id,$product_id,$quantity)";
                    $stidInsert = oci_parse($conn, $sqlInsertCart);
                    oci_execute($stidInsert, OCI_COMMIT_ON_SUCCESS);
                }
            }

            // We are mapping index and quantity here.. the index represents productId and value represents quantity'
            // If the item is already in the cart, update it, else just add to cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }

            // Redirect to checkout.php after adding to cart
            header("Location: checkout.php");
            exit();
        }
    } else {
        echo '<script>alert("Invalid input to the cart")</script>';
    }
}

$qUANTITY_IN_STOCK = false;

if ($qty_in_stock_check <= 0) {
    $qUANTITY_IN_STOCK = true;
}
?>

<!-- Rest of your HTML code -->


<?php
if (isset($_POST['more'])) {
    $more = $_POST['more'];
} else {
    $more = "Less";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="product_detail.css">
    <?php
    if (isset($_GET['product_id'])) {
        $id = $_GET['product_id'];

        $query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID=" . $id;
        $result = oci_parse($conn, $query);
        oci_execute($result);
        $row = oci_fetch_array($result);
    }
    ?>
    <title><?php echo $row['PRODUCT_NAME'] . ' | TapBasket'; ?></title>
    <link rel="stylesheet" href="../product-detail/product_detail.css">
</head>
<body>
    <?php include __DIR__ . '/../header/header.php'; ?>
    <div class="main">
        <?php
            //Getting Product and Shop Details
            if (isset($_GET['product_id'])) {
                $id = $_GET['product_id'];
                
                $query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID=" . $id;
                $result = oci_parse($conn, $query);
                oci_execute($result);
                $row = oci_fetch_array($result);

                $query2 = "SELECT SHOP_NAME 
                            FROM SHOP_REQUEST
                            INNER JOIN
                            SHOP ON 
                            SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID
                            WHERE SHOP.SHOP_ID =" . $row['SHOP_ID'];
                $result2 = oci_parse($conn, $query2);
                oci_execute($result2);
                $row2 = oci_fetch_array($result2);
            }
        ?>
        <div class="product-container">

				<div class="column">
					<img class="product-image" src="../pictures/<?php echo htmlspecialchars($row['PRODUCT_IMAGE']); ?>">
				</div>

				<div class="column">
                <h1><?php echo $row['PRODUCT_NAME']?></h1>
                Sold by: <a href="#"><?php echo $row2['SHOP_NAME']?></a><br><br>
                <?php 
                $discountPrice = 0;
                $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$id";
                $stidDiscount = oci_parse($conn, $stidDiscount);
                oci_execute($stidDiscount);
                while (oci_fetch($stidDiscount)) {
                    $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
                }
                $oldPrice = $row['PRICE'];
            ?>
            <?php
                if ($more == "Less") {
                    $viewButtonText = "More";
                    $str = $row['PRODUCT_DESCRIPTION'];
                    if (str_word_count($str) < 30) {
                        echo $str;
                    } else {
                        $words = str_word_count($str, 2);
                        $pos = array_keys($words);
                        echo substr($str, 0, $pos[30]) . '...';
                    }
                } else {
                    $viewButtonText = "Less";
                    echo $row['PRODUCT_DESCRIPTION'];
            ?>
            <div class="product-details">
                Allergy Information<br>
            </div>
                <?php if (empty($row['ALERGYINFORMATION'])) {echo "No Allergy Information Found.";} else {echo $row['ALERGYINFORMATION'];} ?><br>
            <?php } ?>
            <form method="POST">
                <button class="button" type="submit" name="more" value="<?php echo $viewButtonText?>">View <?php echo $viewButtonText;?></button>
            </form>		


            <div class="product-details">
							<div class="product-details">Quantity:</div>
								<div class="quantity">
										<form class="quantity-form" method="POST">
												<!-- Minus button -->
												<button class="quantity-button minus" type="submit" name="qty-button" value="minus">
														<svg width="10" height="4" viewBox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M15.5833 3.08334H0.416626V0.916672H15.5833V3.08334Z" fill="currentColor"/>
														</svg> 
												</button>  
												<div class="quantity-display">
														<?php
																if (!isset($_POST['qty-button'])) {
																		$qty = 1;
																} else if (isset($_POST['qty-button'])) {
																		$qtyAction = $_POST['qty-button'];
																		if ($qtyAction == "minus") {
																				if ($_POST['qty'] > 1) {
																						$qty = $_POST['qty'] - 1;
																				} else {
																						$qty = 1;
																				}
																		}
																		if ($qtyAction == "plus") {
																				$qty = $_POST['qty'] + 1;
																		}
																}
																echo $qty;
														?>
														<input type="text" name="qty" value="<?php echo $qty ?>" hidden>
												</div> 
												<!-- Plus button -->
												<button class="quantity-button plus" type="submit" name="qty-button" value="plus">
														<svg width="10" height="10" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M15.7832 9.08333H9.28325V15.5833H7.11658V9.08333H0.616577V6.91667H7.11658V0.416664H9.28325V6.91667H15.7832V9.08333Z" fill="currentColor"/>
														</svg>
												</button> 
										</form>
								</div>
            </div>

            <div class="product-details" <?php if (!$qUANTITY_IN_STOCK) {echo 'hidden';} ?>>Out of Stock</div>
            <div class="product-details">Total Price: &nbsp;&#163;
           		<?php echo (($oldPrice - $discountPrice) * $qty)?>
						</div>
                        <div class="buttons">
                            <?php
                            $isInWishList = false; // Define $isInWishList with a default value
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $sqlNew = "SELECT PRODUCT_ID FROM WISHLIST WHERE USER_ID='$user_id'";
                                $stidNew = oci_parse($conn, $sqlNew);
                                oci_execute($stidNew, OCI_DEFAULT);
                                oci_commit($conn);
                                $numrows = oci_fetch_all($stidNew, $response);
                                foreach ($response as $key => $value) {
                                    foreach ($value as $arrkey => $arrvalue) {
                                        if ($arrvalue == $id) {
                                            $isInWishList = true;
                                        }
                                    }
                                }
                            }
                            ?>
                            <?php if ($isInWishList) { ?>
                                <a href="product.php?product_id=<?php echo $id; ?>&category=wishList&type=remove">
                                    <div class="buttons">
                                        <button class="button">Remove from wishlist</button>
                                    </div>
                                </a>
                            <?php } else { ?>
                                <a href="product.php?product_id=<?php echo $id; ?>&category=wishList&type=add">
                                    <div class="buttons-container">
                                        <div class="button-wrapper">
                                            <img class="wishlist" src="../images/wishlist.webp" alt="Add to wishlist">
                                        </div>
                                        <div class="button-wrapper">
                                        <form method="POST" action="add_to_cart.php"> <!-- Change the action to add_to_cart.php or any other appropriate script -->
                                            <input type="hidden" name="product_id" value="<?php echo $id ?>">
                                            <input type="hidden" name="quantity" value="<?php echo $qty ?>">
                                            <button class="button" type="submit" name="add-product" <?php if ($qUANTITY_IN_STOCK == true) echo "disabled"; ?>>
                                                Add to Cart
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>

                    </div>
                </div>
    <?php include __DIR__ . '/../footer/footer.php'; ?>
</body>
</html>
