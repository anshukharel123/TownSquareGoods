<?php
	session_start();
	// Include database connection
	include __DIR__ . '/../database/fetch_cart.php';

	// Initialize cart session if not already set
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = [];
	}

	// Initialize user ID session if not already set
	if (!isset($_SESSION['user_id'])) {
		$_SESSION['user_id'] = '';
	}

	// Establish database connection
	$conn = oci_connect('townsquare', 'townsquare', 'localhost/XE');

	// Fetch cart data from the database
	$cart_items = [];
	if (!empty($_SESSION['cart'])) {
		foreach ($_SESSION['cart'] as $product_id => $quantity) {
			// Fetch product details from the database based on product ID
			$product_query = "SELECT PRODUCT_NAME, PRICE FROM PRODUCT WHERE PRODUCT_ID=$product_id";
			$product_statement = oci_parse($conn, $product_query);
			oci_execute($product_statement);
			$row_product = oci_fetch_assoc($product_statement);

			// Calculate total price for each item
			$item_total = $row_product['PRICE'] * $quantity;

			// Create an array for each item with product details and total price
			$cart_items[] = [
				'product_id' => $product_id,
				'product_name' => $row_product['PRODUCT_NAME'],
				'price' => $row_product['PRICE'],
				'quantity' => $quantity,
				'total' => $item_total
			];
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../checkout/checkout.css">
</head>

<body>
<?php include __DIR__ . '/../header/header.php'; ?>

<div class="container">
    <?php if (empty($cart_items)) : ?>
        <div class="empty-data empty-state">Your Cart Is Empty</div>
    <?php else : ?>
        <!-- Cart Details -->
        <div class="cart-details">
            <!-- Display each item in the cart -->
            <?php foreach ($cart_items as $item) : ?>
                <div class="cart-item">
                    <!-- Display product details, quantity, and total price -->
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Summary and Collection Details -->
<div class="summary-and-collection">
    <!-- Order Summary -->
	<div class="order-summary">
		<h4>Order Summary</h4><br>
		<table class="table">
			<thead>
				<tr>
					<th class="space">Product</th>
					<th class="space">Unit Price</th>
					<th class="space">Quantity</th>
					<th class="space">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$total_price = 0; // Initialize total price variable
				foreach ($cart_items as $item) :
					$total_price += $item['total']; // Update total price
					?>
					<tr>
						<td class="space"><?php echo $item['product_name']; ?></td>
						<td class="space">$<?php echo $item['price']; ?></td>
						<td class="space">
							<div class="quantity-controls">
								<!-- Minus button -->
								<button class="btn btn-sm btn-outline-primary btn-minus" data-product-id="<?php echo $item['product_id']; ?>">-</button>
								<!-- Quantity -->
								<span class="quantity"><?php echo $item['quantity']; ?></span>
								<!-- Plus button -->
								<button class="btn btn-sm btn-outline-primary btn-plus" data-product-id="<?php echo $item['product_id']; ?>">+</button>
							</div>
						</td>
						<td class="space">$<?php echo number_format($item['total'], 2); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<!-- Subtotal Div -->
		<div>
			<p>SUB TOTAL: $<?php echo number_format($total_price, 2); ?></p>
			<p>SHIPPING: FREE</p>
			<p>TOTAL: $<?php echo number_format($total_price, 2); ?></p>
		</div>
	</div>


    <!-- Collection Details -->
    <div class="collection-details">
        <h4>Select a Collection Slot</h4><br>
        <div class="mt-1">Date of Collection: <select><option>5th March, 2024</option></select></div>
        <div class="mt-1">Time of Collection: <select><option>10:00 AM-01:00 PM</option></select></div>
        <div class="payment-method mt-1">
            <span>Payment Method: </span><img src="paypal.png" alt="PayPal Logo">
        </div>
        <button type="button" class="btn btn-primary mt-1">Processed to payment</button>
    </div>
</div><br><br>

<?php include __DIR__ . '/../footer/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Plus button event listeners
        document.querySelectorAll('.btn-plus').forEach(function(button) {
            button.addEventListener('click', function() {
                updateQuantity(this, 1);
            });
        });

        // Minus button event listeners
        document.querySelectorAll('.btn-minus').forEach(function(button) {
            button.addEventListener('click', function() {
                updateQuantity(this, -1);
            });
        });

        // Function to update quantity and total price
        function updateQuantity(button, change) {
            var quantityElement = button.parentNode.querySelector('.quantity');
            var currentQuantity = parseInt(quantityElement.textContent);
            var newQuantity = currentQuantity + change;
            if (newQuantity > 0) {
                quantityElement.textContent = newQuantity;
                updateTotalPrice(button, newQuantity);
                updateSubtotal(); // Update subtotal after updating total price
            }
        }

        // Function to update total price for an item
        function updateTotalPrice(button, quantity) {
            var itemRow = button.closest('tr');
            var unitPrice = parseFloat(itemRow.querySelector('.unit-price').textContent.slice(1));
            var totalPriceElement = itemRow.querySelector('.total-price');
            var newTotalPrice = unitPrice * quantity;
            totalPriceElement.textContent = '$' + newTotalPrice.toFixed(2);
        }

        // Function to update subtotal
        function updateSubtotal() {
            var subtotal = 0;
            document.querySelectorAll('.total-price').forEach(function(element) {
                subtotal += parseFloat(element.textContent.slice(1));
            });
            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
        }
    });
</script>

</body>
</html>
