<?php
    include 'config.php';
    session_start();
    $result = $conn->query("SELECT * FROM BubbleTeaShop");
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
            
            <table class="table">
                <thead>
                    <th style="background-color: whitesmoke"> <b>Store Locations</b></th>
                    <th style="background-color: whitesmoke"><b>Phone Number</b></th>
                    
                </thead>
                
                <tbody>
                    <?php
                    $query = "SELECT * FROM BubbleTeaShop ";
                    $r = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($r)){
                    ?>

                    <tr>
                        <th style="width: 80%"><?php echo $row['Location']?></th>
                        <th style="width: 70%"><?php echo $row['PhoneNumber']?></th>

                    </tr>

                    <?php
                        }
                    ?>
                    
                </tbody>
            </table>
        </div>

        <span>
            <img src="Images/BubbleTeaStore.jpeg" width="300px" height="185px"/>
        </span>
        
        <footer>
            <p> All Rights Reserved </p>
        </footer>
    </body>
</html>