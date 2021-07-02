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
        header("location: signup.php?error=emptyinput");
        exit();
    }

    // Check if phone number is valid.
    if(invalidPhoneNum($PhoneNumber) !== false) {
        header("location: signup.php?error=invalidphone");
        exit();
    }

    // Check if the phone number already exists in out database.
    if(phoneExists($conn, $PhoneNumber) !== false) {
        header("location: signup.php?error=phoneused");
        exit();
    }

    createUser($conn, $NAME, $Birthdate, $PhoneNumber, $Address);
}
else {
    header("location: signup.php");
    exit();
}
?>