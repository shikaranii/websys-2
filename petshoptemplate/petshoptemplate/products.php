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
						<li class="active"><a href="products.php">Products</a></li>
<li class="active"><a href="cart.php">Cart</a></li>

						<li><a href="logout.php">Logout</a></li>
					</ul>
					<?php if (!isset($_COOKIE['email'])): ?>
						<?php else: ?>
						<li>
							<a>Welcome,
								<?php echo $_COOKIE['type'] . '  ' . $_COOKIE['email'] . '' ?>
							</a>
						</li>
						<li><a href="logout.php">Logout</a></li>
	
					<?php endif ?>
		<div id="login_form">
		<?php
                        if (isset($_COOKIE['type'])) {
                            if ($_COOKIE['type'] == 'admin') {
                            } elseif ($_COOKIE['type'] == 'customer') {
							}
                        }
                        ?>
			</div>
			<br>
            <br>
            <br>
			
	<div style="display: flex; flex-wrap: wrap; justify-content: center;">
    <?php
            // Establish a database connection
            $hostname = "localhost";
            $database = "shopee";
            $db_login = "root";
            $db_pass = "";
            $dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

            // Retrieve user's email from the cookie
            $customerEmail = $_COOKIE['email'];

            // Retrieve the user ID based on the email from the Users table
            $userQuery = "SELECT userid FROM user WHERE email='$customerEmail'";
            $userResult = mysqli_query($dlink, $userQuery);
            $user = mysqli_fetch_assoc($userResult);
            $userId = $user['userid'];
            // Get the status parameter from the URL, defaulting to empty
            $status = isset($_GET['status']) ? $_GET['status'] : '';

            // Retrieve the counts for each status
            $pendingCountQuery = "SELECT COUNT(*) AS pendingCount FROM Purchase WHERE status='Pending' AND userid='$userId'";
            $pendingCountResult = mysqli_query($dlink, $pendingCountQuery);
            $pendingCountRow = mysqli_fetch_assoc($pendingCountResult);
            $pendingCount = $pendingCountRow['pendingCount'];

            $acceptedCountQuery = "SELECT COUNT(*) AS acceptedCount FROM Purchase WHERE status='Accepted' AND userid='$userId'";
            $acceptedCountResult = mysqli_query($dlink, $acceptedCountQuery);
            $acceptedCountRow = mysqli_fetch_assoc($acceptedCountResult);
            $acceptedCount = $acceptedCountRow['acceptedCount'];

            $completedCountQuery = "SELECT COUNT(*) AS completedCount FROM Purchase WHERE status='Completed' AND userid='$userId'";
            $completedCountResult = mysqli_query($dlink, $completedCountQuery);
            $completedCountRow = mysqli_fetch_assoc($completedCountResult);
            $completedCount = $completedCountRow['completedCount'];

            $returnRefundCountQuery = "SELECT COUNT(*) AS returnRefundCount FROM Purchase WHERE status='Return/Refund' AND userid='$userId'";
            $returnRefundCountResult = mysqli_query($dlink, $returnRefundCountQuery);
            $returnRefundCountRow = mysqli_fetch_assoc($returnRefundCountResult);
            $returnRefundCount = $returnRefundCountRow['returnRefundCount'];

            // Retrieve user's orders from the Purchase table based on the status
            $query = "SELECT * FROM Purchase WHERE userid='$userId'";
            if (!empty($status)) {
                $query .= " AND status='$status'";
            }

            $result = mysqli_query($dlink, $query);

            // Display the table with the filtered orders
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<table id="purchase-table">';
                echo '<tr><th><a href="purchase.php?status=pending">Pending (' . $pendingCount . ')</a></th><th><a href="purchase.php?status=accepted">Accepted (' . $acceptedCount . ')<a href="purchase.php?status=return/refund">Return/Refund (' . $returnRefundCount . ')</a>                </th><th><a href="purchase.php?status=return/refund">Return/Refund (' . $returnRefundCount . ')</a></th></tr>';
                echo '<tr><th>Product</th><th>Quantity</th><th>Description</th><th>Total</th><th>Date Ordered</th><th>Status</th></tr>';

                // Initialize the total cost variable
                $totalCost = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    // Retrieve product details from the Products table based on the prodid
                    $productId = $row['prodid'];
                    $productQuery = "SELECT * FROM products WHERE prodid='$productId'";
                    $productResult = mysqli_query($dlink, $productQuery);
                    $product = mysqli_fetch_assoc($productResult);

                    // Calculate the cost for the current order
                    $orderCost = $product['ourprice'] * $row['quantity'];

                    // Add the order cost to the total cost
                    $totalCost += $orderCost;

                    echo '<tr>';
                    echo '<td><img src="' . $product['productimage'] . '" alt="' . $product['productname'] . '"></td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>' . $product['productname'] . '<br>' . $product['productdesc'] . '</td>';
                    echo '<td>$' . number_format($product['ourprice'] * $row['quantity'], 2) . '</td>';
                    echo '<td>' . $row['date'] . '</td>';
                    echo '<td>' . $row['status'] . '</td>';
                    echo '</tr>';

                    mysqli_free_result($productResult);
                }
                echo '<tr><td></td><td colspan="2">Total Cost:</td><td id="total_cost">$' . number_format($totalCost, 2) . '</td>';
                echo '</table>';
            } else {

                echo '<table id="purchase-table">';
                echo '<tr><th><a href="purchase.php?status=pending">Pending (' . $pendingCount . ')</a></th><th><a href="purchase.php?status=accepted">Accepted (' . $acceptedCount . ')</a></th><th><a href="purchase.php?status=completed">Completed (' . $completedCount . ')</a></th><th><a href="purchase.php?status=/refund">Return/Refund (' . $returnRefundCount . ')</a></th></tr>';
                echo '<tr><th>Product</th><th>Quantity</th><th>Description</th><th>Total</th><th>Date Ordered</th><th>Status</th></tr>';
                echo '<tr>';
                echo '<td><img src="' . $product['productimage'] . '" alt="' . $product['productname'] . '"></td>';
                echo '<td>' . $row['quantity'] . '</td>';
                echo '<td>' . $product['productname'] . '<br>' . $product['productdesc'] . '</td>';
                echo '<td>$' . number_format($product['ourprice'] * $row['quantity'], 2) . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '</tr>';
                echo '</table>';

            }

            // Close the result sets and the database connection
            mysqli_free_result($result);
            mysqli_free_result($userResult);
            mysqli_close($dlink);
            ?>
                        <div>
         <?php
							$hostname = "localhost";
							$database = "shopee";
							$db_login = "root";
							$db_pass = "";
							$dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

							// check if a category filter is set
							if (isset($_GET['category'])) {
								$category_filter = $_GET['category'];
								$query = "SELECT * FROM Products WHERE prodcat='$category_filter' ORDER BY prodid";
							} else {
								$query = "SELECT * FROM Products ORDER BY prodcat, prodid";
							}

							$result = mysqli_query($dlink, $query);
							$current_cat = '';
            
								// Generate HTML table
								echo "<table style='border-collapse: collapse;'>";
								echo "<tr style='border-bottom: 1px solid black;'><th style='padding: 10px; text-align: left;'>Product Image</th><th style='padding: 10px; text-align: left;'>Product Name</th><th style='padding: 10px; text-align: left;'>Price</th><th style='padding: 10px; text-align: left;'>Quantity</th><th style='padding: 10px; text-align: left;'></th></tr>";
								while ($row = mysqli_fetch_assoc($result)) {
									echo "<tr style='border-bottom: 1px solid black;'>";
									echo "<td style='padding: 10px;'><img src=\"" . $row['productimage'] . "\" alt=\"Image\" style=\"max-width: 200px; max-height: 200px;\"></td>";
									echo "<td style='padding: 10px;'>" . $row['productname'] . "</td>";
									echo "<td style='padding: 10px;'>&#8369;" . $row['ourprice'] . "</td>";
									echo "<td style='padding: 10px;'>" . $row['quantity'] . "</td>";
									echo "<td style='padding: 10px;'>";
									
									if ($row['quantity'] > 0) {
										echo '<form method="get" action="cart.php">';
										echo '<input type="hidden" name="prodid" value="' . $row['prodid'] . '">';
										echo '<button type="submit">Add to Cart</button>';
										echo '</form>';
									} else {
										echo "Out of stock";
									}
									
									echo "</td>";
									echo "</tr>";
								}
								echo "</table>";
							
                  
							mysqli_close($dlink);
							?>



<!-- CLOSING SA CONNECTOR?!?! -->

	
            </div>
				 </div>
        </div>
</body>
</html>