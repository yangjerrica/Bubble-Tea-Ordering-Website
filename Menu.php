<?php
    include 'config.php';
    session_start();
    $result = $conn->query("SELECT DISTINCT Type FROM Drink");
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
    .block {
        display: block;
        width: 155px;
        border-radius: 35px;
        padding: 15px;
        font-size: 18.5px;
        text-align: center;
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

            <div id = "content_area">
            
            <table class="table">
                <thead>
                    <th style="background-color: whitesmoke"> <b>Drink Name</b></th>
                    <th style="background-color: whitesmoke"><b>Type</b></th>
                    <th style="background-color: whitesmoke"><b>Price</b></th>
                    
                </thead>
                
                <tbody>
                    <?php
                        $query = "SELECT D_Name,Type,Price FROM Drink";
                        $r = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_assoc($r)){
                    ?>

                    <tr>
                        <th style="width: 50%"><?php echo $row['D_Name']?></th>
                        <th style="width: 45%"><?php echo $row['Type']?></th>
                        <th style="width: 30%"><?php echo $row['Price']?></th>

                    </tr>

                    <?php
                        }
                    ?>
                </tbody>
            </table>
            
            </div>

        <div id = "sidebar" style = "text-align:center">
                <div><a style="font-size: 20px; color: darkgrey"><br>→ All Series<br></a></div>
                <div><a href="Menu2.php" style="font-size: 20px; color: darkgrey"><br>Milk Tea Series</a><br></div>
                <div><a href="Menu3.php" style="font-size: 20px; color: darkgrey"><br>Fruit Tea Series</a><br></div>
                <div><a href="Menu4.php" style="font-size: 20px; color: darkgrey"><br>Original Taste Tea Series<br></a></div>
                <div><a href="Menu5.php" style="font-size: 20px; color: darkgrey"><br>Add-ons</br></a></div>
                <div><a href="Order.php" style="text-decoration: none;"><br><br><button type="button" class="block" style="margin:auto"><b>Order Now !</b></button></a></div>
        </div>

        <footer>
            <p> All Rights Reserved </p>
        </footer>
    </body>
</html>