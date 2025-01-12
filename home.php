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
    
    <div class="mainview">
        <div class="sidebar">
            <ul>
                <li><img class="userIcon" src="images/user-profile-icon-free-vector-cutout.png" alt=""></li>
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

       
        <div class="titleTasks">
            <h2 style="text-align: center; margin-top: 50px; margin-bottom: 40px; font-size: 30px; font-weight: bold; color: #333;">Hey <span style="color: #60249b; font-style: italic; font-size: 35px;"><?php echo $_SESSION['username']?></span> !</h2>
            <p style="text-align: center; font-size: 20px; color: #666;">Welcome to TaskFlow!<br><br> Here you can manage all your tasks efficiently and stay organized.</p>
            <div style="width: 100%; height: auto; justify-content: center; display: flex; margin-top: -40px; margin-left: 60px;">
                <img src="images/tasks.png" alt="">
            </div>
        </div>
    </div>
    <footer><?php include('footer.php') ?></footer>    

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