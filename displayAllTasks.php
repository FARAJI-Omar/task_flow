<?php
    session_start();
    
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    require_once('classes.php');
    require_once ('connect.php');

    $allTasks = new tasks();
    $allTasks->getTasks(); 
    $tasks = $allTasks->getTaskData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body class="homeBody">
    <?php include('header.php') ?>
    
    <div class="mainview">
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

        <div class="titleTasks">
            <h2 class="title">Task List</h2>
            <div class="tasks">
                <?php foreach ($tasks as $task): ?>
                    <div>
                        <p><strong>Title:</strong> <?php echo htmlspecialchars($task['title']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($task['category']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($task['status']); ?></p>
                        <p><strong>Created by:</strong> <?php echo htmlspecialchars($task['username']); ?></p>
                        <p><strong>Created at:</strong> <?php echo htmlspecialchars($task['created_at']); ?></p>
                        <hr> <!-- Optional: Add a horizontal line between tasks -->
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>
</html>