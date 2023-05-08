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
                        <li><a href="logout.php">Logout</a></li>
					</ul>
			</div>
			
			<div id="body">
			<br>
			<br>
			       <div id="content">		
				        <div class="content">
						
						
						<?php
// Get the current year and month
$year = date('Y');
$month = date('m');

// Get the number of days in the current month
$num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Get the name of the current month, F in format('F') means the full name of the month
$date = new DateTime("$year-$month-01");
$month_name = $date->format('F');

// Get the index of the first day of the month (0 = Sunday, 1 = Monday, etc.)
//The first argument, 'w', specifies that we want to retrieve the day of the week as a numeric value (0 for Sunday, 1 for Monday, and so on).
//strtotime function creates a timestamp representing the first day of the given month and year.
$first_day_index = (int) date('w', strtotime("$year-$month-01"));

// Start the table and print the month name
echo "<table width=80% border=1><caption>$month_name $year</caption>";

// Print the table headers (days of the week)
echo "<tr>";
echo "<th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th>";
echo "<th>Thu</th><th>Fri</th><th>Sat</th>";
echo "</tr>";

// Start a new row for the first week
echo "<tr>";

// Print blank cells for the days before the first day of the month
for ($i = 0; $i < $first_day_index; $i++) {
    echo "<td></td>";
}

// Print the cells for the days of the month
for ($day = 1; $day <= $num_days; $day++) {
    // Start a new row at the beginning of each week
    if ($day > 1 && ($day - 1 + $first_day_index) % 7 == 0) {
        echo "</tr><tr>";
    }

    // Print the cell for the current day
    echo "<td align=center>$day</td>";
}

// Print blank cells for the days after the last day of the month
for ($i = $num_days + $first_day_index; $i < 32; $i++) {
    echo "<td></td>";
}

// End the last row and the table
echo "</tr></table>";
?>

						</div>
					<!--
					    <div id="sidebar">
								
                              								
								   <a href="petmart.html"><img src="images/discount.jpg" width="300" height="790" alt="Pet Shop" title="Pet Shop"></a> 	
								
								
					    </div>
				   </div>
				   
				   <div class="featured">
				        <ul>
							<li><a href="index.php"><img src="images/organic-and-chemical-free.jpg" width="300" height="90" alt="Pet Shop" title="Pet Shop" ></a></li>
							<li><a href="index.php"><img src="images/good-food.jpg" width="300" height="90" alt="Pet Shop" title="Pet Shop" ></a></li>
							<li class="last"><a href="index.html"><img src="images/pet-grooming.jpg" width="300" height="90" alt="Pet Shop" title="Pet Shop" ></a></li>
						</ul>
				        
				   </div>
				  
			
			</div>
			
			<div id="footer">
			        <div class="section">
						<ul>
							<li>
								<img src="images/friendly-pets.jpg" width="240" height="186" alt="Pet Shop" title="Pet Shop">
								<h2><a href="index.php">Friendly Pets</a></h2>
								<p>
								   Lorem ipsum dolor sit amet, consectetuer adepiscing elit,  sed diam nonummy nib. <a class="more" href="index.html">Read More</a> 
								</p>
							</li>	
							<li>
								<img src="images/pet-lover2.jpg" width="240" height="186" alt="Pet Shop" title="Pet Shop">
								<h2><a href="index.php">How dangerous are they</a></h2>
								<p>
								   Lorem ipsum dolor sit amet, cons ectetuer adepis cing, sed diam euis. <a class="more" href="index.html">Read More</a> 
								</p>
							</li>	
							<li>
								<img src="images/healthy-dog.jpg" width="240" height="186" alt="Pet Shop" title="Pet Shop">
								<h2><a href="index.php">Keep them healthy</a></h2>
								<p>
								   Lorem ipsum dolor sit amet, consectetuer adepiscing elit,  sed diam nonu mmy. <a class="more" href="index.html">Read More</a> 
								</p>
							</li>	
							<li>
								
								<h2><a href="index.html">Love...love...love...pets</a></h2>
								<p>
								     Lorem ipsum dolor sit amet, consectetuer adepiscing elit,  sed diameusim. <a class="more" href="index.html">Read More</a> 
								</p>
								<img src="images/pet-lover.jpg" width="240" height="186" alt="Pet Shop" title="Pet Shop">
							</li>	
						</ul>
					</div>
					<div id="footnote">
						<div class="section">
						   &copy; 2011 <a href="index.html">Petshop</a>. All Rights Reserved.
						</div>
					</div>
			</div>
			
	-->	
</div>
</body>
</html>