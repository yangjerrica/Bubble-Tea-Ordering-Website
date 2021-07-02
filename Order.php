<?php
//reference: https://www.youtube.com/watch?v=IO5ezsURqyg
//reference: https://www.youtube.com/watch?v=YloyMFPJyV4&t=464s&ab_channel=ProgrammingWithDicksonProgrammingWithDickson

include 'config.php';
session_start();


if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['Drink'])) {
        $session_array_id = array_column($_SESSION['Drink'], 'hidden_name');
        if (!in_array($_GET['hidden_name'], $session_array_id)) {
            $count = count($_SESSION["Drink"]);
            $session_array = array(
                'drink_Name' => $_POST['hidden_name'],
                "drink_Price" => $_POST['hidden_price'],
                "order_quantity" => $_POST['quantity']
            );

            $_SESSION['Drink'][$count] = $session_array;
            $o_quantity = $_POST['quantity'];
            date_default_timezone_set("America/Vancouver");

            $today = date("mdGis");
            $o_date = date("Y,m,d");
            $o_date_now = $o_date;
            $ordernum = $today;
            $od_name = $_POST['hidden_name'];
            $od_phone = $_SESSION["phoneNumber"];

            $sql = "INSERT INTO Orders (Order_ID,PhoneNumber, D_Name, Quantity, Date) VALUES ($ordernum, $od_phone, '$od_name', $o_quantity, STR_TO_DATE('$o_date_now', '%Y, %m, %d')) ";
        }
    } else {
        $session_array = array(
            'drink_Name' => $_POST['hidden_name'],
            "drink_Price" => $_POST['hidden_price'],
            "order_quantity" => $_POST['quantity']
        );

        $_SESSION['Drink'][0] = $session_array;

        $o_quantity = $_POST['quantity'];
        date_default_timezone_set("America/Vancouver");

        $today = date("mdGis");
        $o_date = date("Y,m,d");
        $o_date_now = $o_date;
        $ordernum = $today;
        $od_name = $_POST['hidden_name'];
        $od_phone = $_SESSION["phoneNumber"];

        $sql = "INSERT INTO Orders (Order_ID,PhoneNumber, D_Name, Quantity, Date) VALUES ($ordernum, $od_phone, '$od_name', $o_quantity, STR_TO_DATE('$o_date_now', '%Y, %m, %d')) ";
    }
}


//reference: https://stackoverflow.com/questions/17330914/how-to-remove-a-row-in-a-php-session-array
if (isset($_GET['action'])) {
    if ($_GET['action'] == "clearall") {
        $od_phone = $_SESSION["phoneNumber"];
        unset($_SESSION['Drink']);
        $sql = "DELETE FROM Orders WHERE PhoneNumber=$od_phone;";
    } 
    
    if (isset($_GET['action'], $_GET['hidden_name']) && $_GET['action'] == 'remove') {
        $od_name = $_GET['hidden_name'];
        $key = array_search($od_name, $_SESSION["Drink"]);
        $od_phone = $_SESSION["phoneNumber"];
        foreach ($_SESSION['Drink'] as $key => $value) {
            if ($value['drink_Name'] == $od_name) {
                unset($_SESSION['Drink'][$key]);
                $sql = "DELETE FROM Orders WHERE PhoneNumber=$od_phone AND D_Name='$od_name';";
                break;
            }
            
        }
    }
}


if (!$conn->query($sql) === TRUE) {
    echo "Please retry";
} else {
    echo "Succeed";
}

?>

<!DOCTYPE html>

<head>
    <metak http-equiv="Content-Type" content="text/html; charset=UTF-8"></metak>
    <metak http-equiv="Content-Type" sidebar="text/html; charset=UTF-8"></metak>
    <title> <?php echo $title; ?> </title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet.css" />
    <meta charset="utf-8">
</head>

<style> 
        .block {
            display: block;
            width: 50px;
            border-radius: 15px;
            background-color: #e3d9ca;
            padding: 5px;
            font-size: 14px;
            text-align: center;
        }
    </style>

<body>
    <div id="wrapper">
        <div id="banner">
            <img src="Images/banner.jpeg" width="650px" height="200px" />
        </div>

        <nav id="navigation">
            <ul id="nav">
                <li><a href="Index.php">Home</a></li>
                <li><a href="Menu.php">Menu</a></li>
                <li><a href="Stores.php">Stores</a></li>
                <li><a href="Join.php">Join</a></li>

            </ul>
        </nav>

        <div id="content_area">
            <h3 style="text-align:center"> Please login before ordering!<a href="login.php" style="float: right;"><button type="button" class="block" style="margin:auto"><b>Login</b></button></a> <br>If not, the orders would be considered invalid :)!</br></h3>
            

            <table class="table">
                <thead>
                    <th style="background-color: #e3d9ca"> <b>Drink Name</b></th>
                    <th style="background-color: #e3d9ca"><b>Type</b></th>
                    <th style="background-color: #e3d9ca"><b>Price</b></th>

                </thead>

                <tbody>
                    <?php
                    $query = "SELECT D_Name,Type,Price FROM Drink";
                    $r = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($r)) {
                    ?>

                        <tr>
                            <form method="post" action="Order.php?D_Name=<?= $row['D_Name'] ?>">
                                <th style="width: auto"><?php echo $row['D_Name'] ?></th>
                                <th style="width: auto"><?php echo $row['Type'] ?></th>
                                <th style="width: 200px"><?php echo $row['Price'] ?></th>
                                <th><input type="hidden" name="hidden_name" value="<?= $row['D_Name'] ?>"></th>
                                <th><input type="hidden" name="hidden_price" value="<?= $row['Price'] ?>"></th>
                                <th><input type="number" name="quantity" style="width:80px;height:25px; text-align:center;" value="1"></th>
                                <th><input type="submit" name="add_to_cart" style="width:auto;height:auto;" value="Add To Cart"></th>
                            </form>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <?php echo $content; ?>

        </div>

        <div id="sidebar" style="text-align:center">
            <h2 style="text-align:center"> Drinks Selected </h2>

            <table class="table">
                <thead>
                    <th style="background-color: #e3d9ca" width="30%"> <b>Drink Name</b></th>
                    <th style="background-color: #e3d9ca" width="10%"><b>Price</b></th>
                    <th style="background-color: #e3d9ca" width="13%"><b>Quantity</b></th>
                    <th style="background-color: #e3d9ca" width="17%"><b>Remove Item</b></th>

                    </thread>

                <tbody>
                    <?php

                    if (!empty($_SESSION['Drink'])) {
                        $total = 0;
                        foreach ($_SESSION["Drink"] as $value) {
                    ?>
                            <tr>
                                <td style="text-align:center"><?php echo $value["drink_Name"]; ?></td>
                                <td><?php echo $value["drink_Price"]; ?></td>
                                <td style="text-align:center"><?php echo $value["order_quantity"]; ?></td>
                                <td ><a href="Order.php?action=remove&hidden_name=<?php echo $value['drink_Name']; ?>" >Delete</a></td>
                            </tr>
                        <?php
                            $total = $total + ($value["order_quantity"] * $value["drink_Price"]);
                        }
                        ?>
                        <tr>
                            <td colspan="3" style="background-color: #e3d9ca; text-align:right;"><b>Total:</b></td>
                            <th style="background-color: #e3d9ca">$<?php echo number_format($total, 2); ?> </th>
                            <td>
                                <a href="Order.php?action=clearall">
                                    <button>Clear Cart</button>
                                </a>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>


        </div>
    </div>


    <footer>
        <p> All Rights Reserved </p>
    </footer>
</body>

</html>