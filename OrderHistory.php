<?php
	include 'config.php';
	session_start();
?>

<!DOCTYPE html>
	<head>
		<metak http-equiv = "Content-Type" content = "text/html; charset=UTF-8"></metak>
		<metak http-equiv = "Content-Type" sidebar = "text/html; charset=UTF-8"></metak>
		<title> <?php echo $title; ?> </title>
		<link rel="stylesheet" type="text/css" href="Styles/stylesheet.css" />
		<meta charset="utf-8">
	</head>

	<body>
		<div id = "wrapper">
			<div id = "banner"> 
				<img src="Images/banner.jpeg" width="650px" height="200px"/>
			</div>

			<nav id = "navigation">
				<ul id = "nav">
					<li><a href="Index.php">Home</a></li>
					<li><a href="Menu.php">Menu</a></li>
					<li><a href="Stores.php">Stores</a></li>
					<li><a href="Join.php">Join</a></li>
					<?php
                 		if(isset($_SESSION["phoneNumber"])) {
                    		echo "<li><a href='logout.php'>Log Out</a></li>";
                            echo "<li><a href='account.php'>Account</a></li>";
                            echo "<li><a href='OrderHistory.php'>History</a></li>";
                 		}
                 		else {
                    		echo "<li><a href='signup.php'>Sign Up</a></li>";
                    		echo "<li><a href='login.php'>Login</a></li>";
                        }
                 	?>
				</ul>
			</nav>

			<div id = "content_area">	
                <h3> Order History </h3>
                <form action="OrderHistory.php" method="post">
                Phone Number: <input type="text" name="phone">
                <input type="submit" value="Search">
                </form>

                <br>

                <?php
                    $phone = $_POST["phone"];

                    if (! (is_null($phone))) {
                        $sql = "SELECT o.Date, o.D_Name, o.Quantity, o.Quantity * d.Price AS Total FROM Orders o, Drink d WHERE o.D_Name = d.D_Name AND PhoneNumber = $phone ORDER BY o.Date";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo "<hr>";
                            while($row = $result->fetch_assoc()) { 
                                echo $row["Date"]. " &nbsp&nbsp&nbsp " . "<span style='display:inline-block; width: 200px; text-align:center'>" . $row["D_Name"] . "</span>" . " &nbsp&nbsp&nbsp " . "Quantity: " . $row["Quantity"] . " &nbsp&nbsp&nbsp " . "Total: $" . $row["Total"] . "<br>" . "<hr>";
                            }
                        } else {
                            echo "No Result Found.";
                        }
                        $conn->close();
                    }
                ?>
			</div>

			<footer>
				<p> All Rights Reserved </p>
			</footer>
	</body>
</html>