<?php
//Reference from https://www.youtube.com/watch?v=gCo6JqGMi30&t=6324s.

if(isset($_POST["submit"])) {
    $NAME = $_POST["name"];
    $Birthdate = $_POST["birthday"];
    $PhoneNumber = $_POST["phone#"];
    $Address = $_POST["address"];

    require_once 'config.php';
    require_once 'function.php';

    // Check if input is empty.
    if(emptyInputRegister($NAME, $Birthdate, $PhoneNumber, $Address) !== false) {
        header("location: account.php?error=emptyinput");
        exit();
    }

    if(nochanges($NAME, $Birthdate, $PhoneNumber, $Address) !== false) {
        header("location: account.php?error=nochanges");
        exit();
    }

    // Check if phone number is valid.
    if(invalidPhoneNum($PhoneNumber) !== false) {
        header("location: account.php?error=invalidphone");
        exit();
    }

    // Check if the phone number already exists in out database.
    if(newPhoneExists($conn, $PhoneNumber) !== false) {
        header("location: account.php?error=newphoneused");
        exit();
    }

    updateUser($conn, $NAME, $Birthdate, $PhoneNumber, $Address);
}
else {
    header("location: signup.php");
    exit();
}
?>