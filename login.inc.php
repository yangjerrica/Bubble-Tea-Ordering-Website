<?php
//Reference from https://www.youtube.com/watch?v=gCo6JqGMi30&t=6324s.

if(isset($_POST["submit"])) {
    $PhoneNumber = $_POST["phone#"];

    require_once 'config.php';
    require_once 'function.php';

    // Checking if the input is empty.
    if(emptyInputLogin($PhoneNumber) !== false) {
        header("location: login.php?error=emptyinput");
        exit();
    }
    
    // Checking if the phone number is valid.
    if(invalidPhoneNum($PhoneNumber) !== false) {
        header("location: login.php?error=invalidphone");
        exit();
    }

    // Proceed to login.
    login($conn, $PhoneNumber);
}
else {
    header("location: login.php");
    exit();
}
?>