<!DOCTYPE html >
<!--  Website template by freewebsitetemplates.com  -->
<html>

<head>
	<title>Pet Shop</title>
	<meta  charset=iso-8859-1" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<!--[if IE 6]>
		<link href="css/ie6.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if IE 7]>
        <link href="css/ie7.css" rel="stylesheet" type="text/css" />  
	<![endif]-->
</head>

<body>

	  
			<div id="header">
	           		<a href="index.php" id="logo"><img src="images/logo.gif" width="310" height="114" alt="" title=""></a>
					<ul class="navigation">
						<li ><a href="index.php">Home</a></li>
						<li class="active"><a href="products.php">products</a></li>
                        <li class="active"><a href="cart.php">Cart</a></li>
                        <li><a href="logout.php">Logout</a></li>
					</ul>
			</div>
			<div id="body">
			<br>
			<br>
	<div id="content">		
	<div class="content">
	<ul>
	<div id="flower">
    	<div class="container">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h1>Your Cart</h1>
                  </div>
				  <div class="section-title">
  <?php
			// Initialize cart array if not yet created
			if (!isset($_COOKIE['cart'])) {
				setcookie('cart', serialize(array()), time() + (86400 * 30), "/"); // 30 days
			}

			// Check if product ID is passed through GET
			if (isset($_GET['prodid'])) {
				// Add product to cart array
				$prodid = $_GET['prodid'];
				$cart = unserialize($_COOKIE['cart']);

				if (isset($cart[$prodid])) {
					$cart[$prodid]['quantity']++;
				} else {
					// Get product details from database
					$hostname = "localhost";
					$database = "shopee";
					$db_login = "root";
					$db_pass = "";
					$dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

					$query = "SELECT * FROM Products WHERE prodid='$prodid'";
					$result = mysqli_query($dlink, $query);
					$product = mysqli_fetch_assoc($result);

					// Add product to cart array
					$cart[$prodid] = array(
						'image' => $product['productimage'],
						'name' => $product['productname'],
						'description' => $product['productdesc'],
						'price' => $product['ourprice'],
						'quantity' => 1
					);
				}

				setcookie('cart', serialize($cart), time() + (86400 * 30), "/"); // 30 days
				header("Location: {$_SERVER['PHP_SELF']}");
				exit;
			}

			// Check if product ID is passed through POST (delete action)
			if (isset($_POST['delete'])) {
				// Remove selected products from cart array
				$delete_items = $_POST['delete'];
				$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();

				foreach ($delete_items as $prodid) {
					if (isset($cart[$prodid])) {
						unset($cart[$prodid]);
					}
				}

				setcookie('cart', serialize($cart), time() + (86400 * 30), "/"); // 30 days
				header("Location: {$_SERVER['PHP_SELF']}");
				exit;
			}

			// Place order functionality
			if (isset($_POST['place_order'])) {
				$cart = unserialize($_COOKIE['cart']);
				foreach ($cart as $prodid => $product) {
					if (isset($_POST['purchase']) && in_array($prodid, $_POST['purchase'])) {
						$quantity = $_POST['quantity'][$prodid];
						// Update the quantity in the database
						$hostname = "localhost";
						$database = "shopee";
						$db_login = "root";
						$db_pass = "";
						$dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");
						$query = "UPDATE Products SET quantity = quantity - $quantity WHERE prodid='$prodid'";
						mysqli_query($dlink, $query);
						// Remove purchased product from the cart
						unset($cart[$prodid]);
					}
				}
				// Save updated cart after placing the order
				setcookie('cart', serialize($cart), time() + (86400 * 30), "/"); // 30 days
				header("Location: {$_SERVER['PHP_SELF']}");
				exit;
			}

			function updatePrice($prodid, $price)
			{
				$quantity = $_POST['quantity'][$prodid];
				$subtotal = $price * $quantity;

				// Update the quantity and subtotal in the cart array
				$cart = unserialize($_COOKIE['cart']);
				$cart[$prodid]['quantity'] = $quantity;
				$cart[$prodid]['subtotal'] = $subtotal;

				// Save the updated cart array to the cookie
				setcookie('cart', serialize($cart), time() + (86400 * 30), '/'); // Adjust the expiration time as needed
			}
			// Display cart table
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array(); // Check if the cart cookie is set
			if (empty($cart)) {
				echo '<p>Your cart is empty. Start shopping <a href="products.php">here</a>.</p>';
			} else {
				echo '<form method="post">';
				echo '<table id="cart-table">';
				echo '<tr><th></th><th id="product-header">Product</th><th></th><th id="description-header">Description</th><th id="name-header">Name</th><th id="quantity-header">Quantity</th><th id="price-header">Price</th><th id="action-header">Action</th></tr>';
				$total_price = 0;

				if (!empty($cart)) { // Check if the cart is not empty
					// Establish a database connection
					$hostname = "localhost";
					$database = "shopee";
					$db_login = "root";
					$db_pass = "";
					$dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

					foreach ($cart as $prodid => $product) {
						// Get the available quantity of the product from the database
						$query = "SELECT quantity FROM Products WHERE prodid='$prodid'";
						$result = mysqli_query($dlink, $query);

						if ($result) {
							$row = mysqli_fetch_assoc($result);
							$availableQuantity = $row['quantity'];

							// Update price based on selected quantity
							if (isset($_POST['quantity'][$prodid])) {
								$quantity = $_POST['quantity'][$prodid];
							} else {
								$quantity = $product['quantity'];
							}

							$subtotal = $product['price'] * $quantity;
							$total_price += $subtotal;

							echo '<tr id="cart-row-' . $prodid . '">';
							echo '<td><input type="checkbox" name="purchase[]" value="' . $prodid . '" id="checkbox-' . $prodid . '"></td>';
							echo '<td><img src="' . $product['image'] . '" alt="' . $product['name'] . '" id="image-' . $prodid . '" width="200" height="200"></td>';
							echo '<td></td>';
							echo '<td>' . $product['description'] . '</td>';
							echo '<td>' . $product['name'] . '</td>';
							echo '<td>';
							// For seeing all of the total quantity in the database
							echo '<select name="quantity[' . $prodid . ']" onchange="this.form.submit()" id="quantity-' . $prodid . '">';

							for ($i = 1; $i <= $availableQuantity; $i++) {
								echo '<option value="' . $i . '"';
								if ($i == $quantity) {
									echo ' selected';
								}
								echo '>' . $i . '</option>';
							}
							echo '</select>';
							echo '</td>';
							echo '<td>$' . number_format($subtotal, 2) . '</td>';
							echo '<td><button type="submit" name="delete[]" value="' . $prodid . '" id="delete-' . $prodid . '">Delete</button></td>';
							echo '</tr>';
						}
					}

					// Close the result set
					mysqli_free_result($result);

					// Close the database connection
					mysqli_close($dlink);
				}

				echo '<tr><td></td><td></td><td colspan="4">Total Price:</td><td id="total_price">$' . number_format($total_price, 2) . '</td>';
				echo '</table>';
				echo '<button type="submit" name="place_order" id="place_order">Place Order</button>';
				echo '</form>';
			}

			?>
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
</body>
</html>
