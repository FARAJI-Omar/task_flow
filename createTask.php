<?php
    session_start();
    
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
    require_once('classes.php');
    require_once ('connect.php');

    $db = new database();
    $taskManager = new tasks(); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createTask'])) {
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['taskDescription']));
        $categoryId = intval($_POST['category']);
    
        // Save the new task
        $result = $taskManager->saveTask($title, $description, $categoryId);
        echo $result; 
    }

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

</head>
<body>
    <?php include('header.php') ?>

    <div class="createTask">
        <form action="createTask.php" method="post">
            <h2>Create new task</h2>
            <label for="tasktitle">Title</label>
            <input id="tasktitle" type="text" name="title" placeholder="Enter task title" required>

            <label for="taskdesc">Task Description</label>
            <input id="taskdesc" type="text" name="taskDescription" placeholder="Enter task description" required>

            <label for="taskcategory">Choose category</label>
            <select id="taskcategory" name="category" required>
                <option value="1">Basic</option>
                <option value="2">Bug</option>
                <option value="3">Feature</option>
            </select>
            <input type="submit" name="createTask" value="Create task">
        </form>
    
</body>
</html>