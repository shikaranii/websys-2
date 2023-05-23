<!DOCTYPE html >
<!--  Website template by freewebsitetemplates.com  -->
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
						<li><a href="calendar.php">Calendar</a></li>
                        <li><a href="logout.php">Logout</a></li>
					</ul>
			</div>
			
			<div id="body">
			<br>
			<br>
			<br>
			<br>
			       <div id="content">		
				        <div class="content">
						<?php
            $hostname = "localhost";
            $database = "shopee";
            $db_login = "root";
            $db_pass = "";

            // Create a connection to the database
            $dlink = mysqli_connect($hostname, $db_login, $db_pass, $database) or die("Could not connect");

            // Get the current year and month
            $year = date('Y');
            $month = date('m');

            // Get the number of days in the current month
            $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            // Get the name of the current month
            $month_name = date('F', mktime(0, 0, 0, $month, 1, $year));

            // Retrieve the count of purchases for each day in the current month
            $query = "SELECT DAY(date) AS day, COUNT(*) AS orderCount FROM Purchase WHERE YEAR(date) = $year AND MONTH(date) = $month GROUP BY DAY(date)";
            $result = mysqli_query($dlink, $query);

            // Create an empty array to store the order counts
            $orderCounts = array();

            // Store the order counts in the array
            while ($row = mysqli_fetch_assoc($result)) {
                $orderCounts[$row['day']] = $row['orderCount'];
            }

            echo "<table width='80%' border='1'>";
            echo "<caption>$month_name $year</caption>";
            echo "<tr>";
            echo "<th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>";
            echo "</tr>";
            echo "<tr>";

            // Get the index of the first day of the month (0 = Sunday, 1 = Monday, etc.)
            $first_day_index = (int) date('w', strtotime("$year-$month-01"));

            // Print blank cells for the days before the first day of the month
            for ($i = 0; $i < $first_day_index; $i++) {
                echo "<td></td>";
            }

            // Print the cells for the days of the month
            for ($day = 1; $day <= $num_days; $day++) {
                // Start a new row at the beginning of each week
                if (($day + $first_day_index - 1) % 7 === 0) {
                    echo "</tr><tr>";
                }

                // Get the order count for the current day
                $orderCount = isset($orderCounts[$day]) ? $orderCounts[$day] : 0;

                // Highlight the current day
                $class = ($day == date('d')) ? 'current-day' : '';

                // Create the link to customerorders.php if there are orders on that day
                $link = ($orderCount > 0) ? "<a href='customers.php?date=$year-$month-$day'>$day ($orderCount)</a>" : $day;

                // Display the day with the link (if applicable)
                echo "<td align='center' class='$class'>$link</td>";
            }

            // Print blank cells for the days after the last day of the month
            $last_day_index = ($first_day_index + $num_days - 1) % 7;
            for ($i = $last_day_index; $i < 6; $i++) {
                echo "<td></td>";
            }

            echo "</tr>";
            echo "</table>";

            // Close the database connection
            mysqli_close($dlink);
            ?>
						</div>
</div>
</body>
</html>