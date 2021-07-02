
<?php
//Reference from https://www.youtube.com/watch?v=gCo6JqGMi30&t=6324s.

    session_start();
    session_unset();
    session_destroy();

    header("location: index.php");
    exit();
?>