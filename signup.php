<?php
//Reference from https://www.youtube.com/watch?v=gCo6JqGMi30&t=6324s.

$title = "register";
$content = '
<h2>Sign Up</h2>
     <form action = "signup.inc.php" method="post">
     <label>
        <input type = "text" name = "name" placeholder = "Full Name">
        </label>
        
        <label>
        <input type = "text" name = "address" placeholder = "Address">
        </label>

        <label>
        <input type = "date" name = "birthday" min = "1920-01-01" max= "2020-01-01";
        placeholder = "yyyy-mm-dd">
        </label>
        
        <label>
        <input type="number" step="1" name = "phone#" placeholder = "Phone #">
        </label>

        <label2>
        <button type = "submit" name = "submit">Sign up</button>
        </label2>
    </form>';
    
    // Give responds if error detected.
    if(isset($_GET["error"])) {
        if($_GET["error"] == "emptyinput") {
            $content .= "<p style='color:red;'>Please fill in all fields!</p>";
        }
        else if ($_GET["error"] == "invalidphone") {
            $content .= "<p style='color:red;'>Please fill in a valid phone number!</p>";
        }
        else if ($_GET["error"] == "phoneused") {
            $content .= "<p style='color:red;'>This phone number is already used for another account!</p>";
        }
        else if ($_GET["error"] == "none") {
            $content .= "<p style='color:green;'>Account created!</p>";
        }
    }    

    include 'Template.php';
?>