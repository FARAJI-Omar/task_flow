<?php
    session_start();

    require_once('connect.php');
    require_once('classes.php');

    $db = new database();
    $users = new users();

    echo $_SESSION['username'];
    


?>