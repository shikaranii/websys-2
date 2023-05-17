<!DOCTYPE html >
<html>

<head>
	<title>Pet Shop</title>
	<meta  charset=iso-8859-1" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="header">
	<a href="index.php" id="logo"><img src="images/logo.gif" width="310" height="114" alt="" title=""></a>
	<ul class="navigation">
	<li ><a href="index.php">Home</a></li>
	<li class="active"><a href="products.php">Products</a></li>
    <li class="active"><a href="cart.php">Cart</a></li>
    <li class="active"><a href="myorders.php">My Orders</a></li>
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
          
            $hostname = "localhost";
            $database = "shopee";
            $db_login = "root";
            $db_pass = "";
            $dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

        
            $customerEmail = $_COOKIE['email'];

        
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
                echo '<table id="myorders-table">';
                echo '<tr><th><a href="myorders.php?status=pending">Pending (' . $pendingCount . ')</a></th><th><a href="myorders.php?status=accepted">Accepted (' . $acceptedCount . ')</a></th><th><a href="myorders.php?status=completed">Completed (' . $completedCount . ')</a></th><th><a href="myorders.php?status=return/refund">Return/Refund (' . $returnRefundCount . ')</a></th></tr>';
                echo '<tr><th>Product</th><th>Quantity</th><th>Description</th><th>Total</th><th>Date Ordered</th><th>Status</th></tr>';

                // Initialize the total cost variable
                $totalCost = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    // Retrieve product details from the Products table based on the prodid
                    $productId = $row['prodid'];
                    $productQuery = "SELECT * FROM Products WHERE prodid='$productId'";
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

                echo '<table id="myorders-table">';
                echo '<tr><th><a href="myorders.php?status=pending">Pending (' . $pendingCount . ')</a></th><th><a href="myorders.php?status=accepted">Accepted (' . $acceptedCount . ')</a></th><th><a href="myorders.php?status=completed">Completed (' . $completedCount . ')</a></th><th><a href="myorders.php?status=/refund">Return/Refund (' . $returnRefundCount . ')</a></th></tr>';
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
            </div>
				 </div>
        </div>
</body>
</html>