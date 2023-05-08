
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
						<li class="active"><a href="index.php">Home</a></li>
            <?php
						if (isset($_COOKIE['type'])) {
							if ($_COOKIE['type'] == 'admin') {
								echo '<li><a href="calendar.php">Calendar</a></li>';
							} elseif ($_COOKIE['type'] == 'customer') {
                echo '<li><a href="petmart.html">PetMart</a></li>';
                echo '<li><a href="cart.php">Cart</a></li>';
							}
						}
						?>
            <?php if (isset($_COOKIE['email'])): ?>
              <?php if (!isset($_COOKIE['email'])): ?>
				<?php else: ?>
					<li><a href="logout.php">Logout</a></li>
					<?php endif 
          ?>
            <?php else: 
                    echo '<li class="active"><a class="nav-link" href="index.php?action=login&#login_form">Login</a></li>';
                    echo '<li class="active"> <a class="nav-link" href="index.php?action=register&#login_form">Register</a></li>';
                ?>           
                   <?php endif ?>
            <?php
    $hostname="localhost";
    $database="shopee";
    $db_login="root";
    $db_pass="";

    $dlink = mysql_connect($hostname, $db_login, $db_pass) or die("Could not connect");
    mysql_select_db($database) or die("Could not select database");

    // Registration Function-------------------------------------------------------------------------------------------- 
		if ($_REQUEST['name'] != "" && $_REQUEST['email'] != "" && $_REQUEST['password'] != "" && $_REQUEST['contact'] != "" && $_REQUEST['address'] != "") {
			$query = "SELECT * FROM user WHERE email='" . $_REQUEST['email'] . "'";
			$result = mysql_query($query) or die(mysql_error());
			$num_results = mysql_num_rows($result);
		
			if ($num_results == 0) {
				// Check if this is the first registered user
				$query = "SELECT * FROM user";
				$result = mysql_query($query) or die(mysql_error());
				$num_results = mysql_num_rows($result);
				
				$user_type = 'customer';
				
				if ($num_results == 0) {
					// First registered user is admin
					$user_type = 'admin';
				}
				
				$query = "INSERT INTO user(email, paswrd, contact, custname, address, usertype, user_date, user_ip) VALUES('" . $_REQUEST['email'] . "', '" . $_REQUEST['password'] . "', '" . $_REQUEST['contact'] . "', '" . $_REQUEST['name'] . "' ,'" . $_REQUEST['address'] . "', '" . $user_type . "', '" . date("Y-m-d h:i:s") . "', '" . $_SERVER['REMOTE_ADDR'] . "')";
				$result = mysql_query($query) or die(mysql_error());
				echo "<meta http-equiv='refresh' content='0;url=index.php?action=login&#login_form'>";
			} else {
				echo "<meta http-equiv='refresh' content='0;url=index.php?registered=user&register=true&#register'>";
				echo '<script>alert("Account already registered.")</script>';
			}
		}
		// Registration Function--------------------------------------------------------------------------------------------

    // Register

    if($_REQUEST['name'] !="" && $_REQUEST['email'] !="" && $_REQUEST['password'] !="" && $_REQUEST['contact'] !="" && $_REQUEST['address'] !=""){
        $query = "select * from user where email='". $_REQUEST['email'] . "'";
        $result = mysql_query($query) or die(mysql_error());
        $num_results = mysql_num_rows($result);

      
        if ($num_results==0){
            $query = "insert into user(email, paswrd, contact, custname, address, usertype, user_date, user_ip) values('" . $_REQUEST['email'] . "', '" . $_REQUEST['password'] . "', '". $_REQUEST['contact'] . "', '" . $_REQUEST['name'] . "' ,'" . $_REQUEST['address'] . "', 'customer', '" . date("Y-m-d h:i:s") . "', '". $_SERVER['REMOTE_ADDR'] ."')";
            $result = mysql_query($query) or die(mysql_error());
            echo "<meta http-equiv='refresh' content='0;url=index.php?action=login&#login_form'>";
        }else{
            echo "<meta http-equiv='refresh' content='0;url=index.php?registered=user&register=true&#register'>";
            echo '<script>alert("Account Already Registered")</script>';
        }
    }

    // End of Register

    // Login

    if ($_REQUEST['logging_in'] == true){
      $query = "select * from user where email='". $_REQUEST['email'] ."' and paswrd='". $_REQUEST['password'] ."'";
      $result = mysql_query($query) or die(mysql_error());
      $total_results = mysql_num_rows($result);
      $row = mysql_fetch_array($result);
      if ($total_results == 0) {

        echo '<meta http-equiv="refresh" content="0;url=index.php?action=register&#login_form">';
        echo '<script>alert("Account not yet Registered!")</script>';

        
      }else{
        setcookie("email", $row['email'], time() + 3600, "/");
        setcookie("type", $row['usertype'], time() + 3600, "/");
        echo '<meta http-equiv="refresh" content="0,url=index.php?user=logged_in">';
      }
    }

    // End of Login

    // Register Form

    if ($_REQUEST['action'] == 'register'){
        print('<h1>Registration</h1>');
        print('<form action=index.php method=post>');
        print('Enter Name<input type=text name=name><br>');
        print('Enter Email<input type=text name=email><br>');
        print('Enter Password<input type=text name=password><br>');
        print('Enter Contact<input type=text name=contact><br>');
        print('Enter Address<input type=text name=address><br>');
        print('<input type=submit value=submit>');
        print('</form>');
    }

    // End of Register Form
    // Login Form

    if ($_REQUEST['action'] == 'login'){
      print ('<h1 id="login">Login</h1>');
      print('<form action=index.php?logging_in=true method=post>');
      print('Enter Email<input type=text name=email><br>');
      print("Enter Password<input type=text name=password><br>");
      print('<input type=submit value=submit name=submit>');
      print('</form>');
    }

    // End of Login Form
  ?>

                    </ul>
					</ul>
					<br>
          <br>
          &nbsp &nbsp <h1>Welcome, <?php echo $_COOKIE['type'] . '  ' . $_COOKIE['email'] . '' ?></h1>
			</div>
			<div id="body">
					<div class="banner">&nbsp;</div>
			       <div id="content">
				        <div class="content">
						</div>
          
				   <div class="featured">
           ALL RIGHTS RESERVED 
				   </div>
				  
			
			</div>

	
</body>

</html>