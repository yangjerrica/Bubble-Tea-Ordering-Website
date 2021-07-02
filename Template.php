<?php
include 'config.php';
if (!isset($_SESSION)) {
	session_start();
}
?>

<!DOCTYPE html>

<head>
	<metak http-equiv="Content-Type" content="text/html; charset=UTF-8"></metak>
	<metak http-equiv="Content-Type" sidebar="text/html; charset=UTF-8"></metak>
	<title> <?php echo $title; ?> </title>
	<link rel="stylesheet" type="text/css" href="Styles/stylesheet.css" />
	<meta charset="utf-8">
</head>

<body>
	<div id="wrapper">
		<div id="banner">
			<img src="Images/banner.jpeg" width="650px" height="200px" />
		</div>

		<nav id="navigation">
			<ul id="nav">
				<li><a href="Index.php">Home</a></li>
				<li><a href="Menu.php">Menu</a></li>
				<li><a href="Stores.php">Stores</a></li>
				<li><a href="Join.php">Join</a></li>
				<?php
				if (isset($_SESSION["phoneNumber"])) {
					echo "<li><a href='logout.php'>Log Out</a></li>";
					echo "<li><a href='account.php'>Account</a></li>";
					echo "<li><a href='OrderHistory.php'>History</a></li>";
				} else {
					echo "<li><a href='signup.php'>Sign Up</a></li>";
					echo "<li><a href='login.php'>Login</a></li>";
				}
				?>
			</ul>
		</nav>

		<div id="content_area">
			<?php echo $content; ?>
		</div>

		<div id="sidebar">
			<h3 style="margin: auto; text-align: center;"> BEST SELLERS</h3>

			<br>

			<?php
			$sql = "SELECT D_Name, Sum(Quantity) Sum FROM Orders GROUP BY D_Name ORDER BY Sum(Quantity) DESC LIMIT 3";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo " ★ " . $row["D_Name"] . "<br>" . " &nbsp&nbsp&nbsp Quantity Sold: " . $row["Sum"] . "<br>" . "<br>";
				}
			}
			?>

			<hr>

			<?php
			echo "Ordered by every customers: ";

			$sql = "SELECT d.D_Name FROM Drink d WHERE NOT EXISTS (SELECT c.PhoneNumber FROM Customer c WHERE c.PhoneNumber NOT IN (SELECT o.PhoneNumber From Orders o, Customer c WHERE d.D_Name = o.D_Name AND c.PhoneNumber = o.PhoneNumber))";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<br>" . $row["D_Name"];
				}
			} else {
				echo  "<br>" . "None";
			}
			?>

			<br>
			<br>
			<hr>

			<?php
			echo "Number of customers who have made a purchase today: ";

			date_default_timezone_set("America/Vancouver");

			$o_date = date("Y,m,d");
			$o_date_now = $o_date;
			$sql = "SELECT COUNT(DISTINCT PhoneNumber) AS NUM FROM Orders WHERE PhoneNumber IN (SELECT PhoneNumber FROM Orders WHERE Date = STR_TO_DATE('$o_date_now', '%Y, %m, %d') GROUP BY PhoneNumber HAVING COUNT(Order_ID) >= 1)";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo $row["NUM"];
				}
			} else {
				echo "0";
			}

			$conn->close();
			?>
		</div>

		<footer>
			<p> All Rights Reserved </p>
		</footer>
</body>

</html>