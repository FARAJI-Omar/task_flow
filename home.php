<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: welcome.php');
        exit();
    }

    require_once('connect.php');
    require_once('classes.php');
    $db = new database();
    $users = new users();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

</head>
<body class="homeBody">
    <?php include('header.php') ?>

    <div class="sidebar">
        <ul>
            <li><img class="userIcon" src="images/user icon2.png" alt=""></li>
            <li><h3><?php echo $_SESSION['username']?></h3></li>
            <li><a href="displayAllTasks.php">View all tasks</a></li>
            <li><a href="displayUserTasks.php">View my tasks</a></li>
            <li><a href="createTask.php">Create new task</a></li>
            <li>
                <form action="home.php" method="POST">
                    <input type="submit" name="logout" value="log Out" class="logout">
                </form>
            </li>
        </ul>

    </div>
    
</body>
</html>

<!-- ----------------logout-------------------------- -->

<?php
    if(isset($_POST["logout"])){
        session_destroy();
        header("location: welcome.php");
        exit();
    }
?>