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
          ?>
            </div>
				 </div>
        </div>
</body>
</html>