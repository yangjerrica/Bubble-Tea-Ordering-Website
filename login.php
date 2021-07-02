<?php
//Reference from https://www.youtube.com/watch?v=gCo6JqGMi30&t=6324s.

$title = "login";
$content = '
<h2>Login</h2>
     <form action = "login.inc.php" method="post">    
        <label>
        <input type = "text" name = "phone#" placeholder = "Phone #">
        </label>

        <label2>
        <button type = "submit" name = "submit">login</button>
        </label2>
    </form>';
    
    // Give responds if error detected.
    if(isset($_GET["error"])) {
        if($_GET["error"] == "emptyinput") {
            $content .= "<p style='color:red;'>Please fill in your phone number!<p>";
        }
        else if ($_GET["error"] == "invalidphone") {
            $content .= "<p style='color:red;'>Please enter a valid phone number!</p>";
        }
        else if ($_GET["error"] == "phone_dont_exist") {
            $content .= "<p style='color:red;'>This phone number does not associate with any account!</p>";
        }
    } 

    include 'Template.php';
?>