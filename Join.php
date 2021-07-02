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

	<style>
	.submit_box {
		display: block;
		width: 100px;
		height: 35px;
		border-radius: 30px;
		font-size: 15px;
		margin-top: 30px;
		margin-bottom: 30px;
		margin-left: 340px;
	}
	</style>

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

			<div id = "content_area" style="text-align:center; width:515px">
				<h1> Franchise Application </h1> 
				
				<form action="Join.php" method="post">
					Name: <input type="text" name="name" style="margin-left: 113px; width: 185px;">
					<br>
					<br>
					Phone: <input type="number" name="phone" style="margin-left: 110px; width: 185px;">
					<br>
					<br>
					Personal Statement: <input type="text" name="personal_statement" style="width: 185px;">
					<br>
					<input type="submit" value="Submit" class = "submit_box">
				</form>


				<?php
					$a_name = $_POST["name"];
					$a_phone = $_POST["phone"];
					$a_personal_statement = $_POST["personal_statement"];

					if (! (is_null($a_name) AND is_null($a_phone) AND is_null($a_personal_statement))) {
						$sql = "INSERT INTO ApplicantForFranchising (Name, Phone, PersonalStatement) VALUES ('$a_name', $a_phone, '$a_personal_statement')";
					
						if ($conn->query($sql) === TRUE) {
							echo "Your application have been submitted.";
						} else {
							echo "Please fill out the form carefully before submitting.";
						}
			
						$conn->close();	
					}				
				?>	
			</div>

			<span>
				<img src="Images/JoinUs.jpeg" width="475px" height="315px"/>
			</span>

			<footer>
				<p> All Rights Reserved </p>
			</footer>
	</body>
</html>