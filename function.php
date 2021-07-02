<?php
//Reference from https://www.youtube.com/watch?v=gCo6JqGMi30&t=6324s.

//Checkig if the input is empty. Returns true if the input is empty.
function emptyInputRegister($NAME, $Birthdate, $PhoneNumber, $Address){
    $result;
    if (empty($NAME) || empty($Birthdate) || empty($PhoneNumber) || empty($Address)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

//Checking if the phone number is valid(which means it must have 10 digits). Returns true if not valid. 
function invalidPhoneNum($PhoneNumber){
    $result;
    if (strlen($PhoneNumber) !== 10) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

//Checking if the phone number already exists in database. Returns true if the number is already in db.
function phoneExists($conn, $PhoneNumber) {
    $sql = "SELECT * FROM customer where PhoneNumber = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $PhoneNumber);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

//Helper function for registering a new customer into the database.
function createUser($conn, $NAME, $Birthdate, $PhoneNumber, $Address) {
    $sql = "INSERT INTO customer(Name, Birthdate, PhoneNumber, Address) VALUES(?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssis", $NAME, $Birthdate, $PhoneNumber, $Address);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: signup.php?error=none");
    exit();
}

//Checking if the input is empty. Returns true if the input is empty.
function emptyInputLogin($PhoneNumber){
    $result;
    if (empty($PhoneNumber)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

/*Checking if the phone number tring to login exists in database or not. 
        If the phone number does not exist then returnto the login page and return error.
        If the phone number exists, then succesfully login. 
*/
function login($conn, $PhoneNumber) {
    $phoneExists = phoneExists($conn, $PhoneNumber);

    if($phoneExists == false) {
        header("location: login.php?error=phone_dont_exist");
        exit();
    }
    else if($phoneExists == true) {
        session_start();
        $_SESSION["phoneNumber"] = $phoneExists["PhoneNumber"];
        $_SESSION["customerid"] = $phoneExists["C_ID"];
        $_SESSION["birthdate"] = $phoneExists["Birthdate"];
        $_SESSION["name"] = $phoneExists["Name"];
        $_SESSION["address"] = $phoneExists["Address"];


        header("location: index.php");
        exit();
        }
}

// Checking if there are changes made on update page.
function nochanges($NAME, $Birthdate, $PhoneNumber, $Address) {
    session_start();
    $reult;

    if($NAME == $_SESSION["name"] && $Birthdate == $_SESSION["birthdate"] && $PhoneNumber == $_SESSION["phoneNumber"]
      && $Address == $_SESSION["address"]) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

// Checking whether the phone number updated or not, 
// if it did update, then check if the new number is used by another user.
function newPhoneExists($conn, $PhoneNumber) {
    session_start();
    $reult;
    if ($PhoneNumber == $_SESSION["phoneNumber"]) {
        $result = false;
        return $result;
    }
    else {
        $sql = "SELECT * FROM customer where PhoneNumber = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: signup.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $PhoneNumber);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }
}

// Write new update information into the database.
function updateUser($conn, $NAME, $Birthdate, $PhoneNumber, $Address) {
    session_start();
    $sql = "UPDATE customer SET Name = ?, Birthdate = ?, PhoneNumber = ?, Address = ? WHERE C_ID = ".$_SESSION["customerid"].";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssis", $NAME, $Birthdate, $PhoneNumber, $Address);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: account.php?error=none");
    exit();
}
?>