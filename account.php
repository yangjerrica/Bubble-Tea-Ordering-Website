<?php
//Reference from https://www.youtube.com/watch?v=gCo6JqGMi30&t=6324s.
session_start();
$phone = $_SESSION["phoneNumber"];
$birth = $_SESSION["birthdate"];
$name = $_SESSION["name"];
$address = $_SESSION["address"];

$title = "account";
$content = '
<h2>Account</h2>
     <form action = "account.inc.php" method="post">
     <label>
        <input type = "text" name = "name" placeholder = "Full Name" value = '.$name.'>
        </label>
        
        <label>
        <input type = "text" name = "address" placeholder = "Address" value = '.$address.'>
        </label>

        <label>
        <input type = "date" name = "birthday" min = "1920-01-01" max= "2020-01-01";
        placeholder = "yyyy-mm-dd" value = '.$birth.'>
        </label>
        
        <label>
        <input type="number" step="1" name = "phone#" placeholder = "Phone #" value = '.$phone.'>
        </label>

        <label2>
        <button type = "submit" name = "submit">Update</button>
        </label2>
    </form>';
    
    // Give responds if error detected.
    if(isset($_GET["error"])) {
        if($_GET["error"] == "emptyinput") {
            $content .= "<p style='color:red;'>Please fill in all fields!</p>";
        }
        else if ($_GET["error"] == "nochanges") {
            $content .= "<p style='color:red;'>Make changes to something in order to update!</p>";
        }
        else if ($_GET["error"] == "invalidphone") {
            $content .= "<p style='color:red;'>Please fill in a valid phone number!</p>";
        }
        else if ($_GET["error"] == "newphoneused") {
            $content .= "<p style='color:red;'>This phone number is already used for another account!</p>";
        }
        else if ($_GET["error"] == "none") {
            session_unset();
            session_destroy();
            header("refresh:5; url = index.php");
            echo"Updated successfully, please login again. Redirect to home page in 5 seconds...";
            exit();
        }
    }
    include 'Template.php';
?>