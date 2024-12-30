<?php
    session_start();
    
    if (!isset($_SESSION['username'])) {
        header('Location: welcome.php');
        exit();
    }
    require_once('classes.php');
    require_once ('connect.php');

    if(isset($_POST["cancel"])){
       
        header("location: home.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createTask'])) {
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['taskDescription']));
        $category = intval($_POST['category']);

        switch ($category) {
            case 1:
                $categorizedTask = new BasicTask();
                break;
            case 2:
                $categorizedTask = new BugTask();
                break;
            case 3:
                $categorizedTask = new FeatureTask();
                break;
            default:
            echo '<script>
            if (confirm("Must select a category.")) {
                window.location.href = "createTask.php";
            }
            </script>';            
            exit();
        }

        // set task properties
        if ($categorizedTask->setTitle($title) && $categorizedTask->setDescription($description)){
                $categorizedTask->setCategory($categorizedTask->getCategory());
            
            // Save the task
            if (!$categorizedTask->saveTask()) {
                echo '<p class="error">Failed to create task.</p>';
            }
        } 
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
            <input id="tasktitle" type="text" name="title" placeholder="Enter task title">

            <label for="taskdesc">Task Description</label>
            <input id="taskdesc" type="text" name="taskDescription" placeholder="Enter task description">

            <label for="taskcategory">Choose category</label>
            <select id="taskcategory" name="category">
                <option value="">--Select a category:--</option>
                <option value="1">Basic</option>
                <option value="2">Bug</option>
                <option value="3">Feature</option>
            </select>
            <div class="createTaskButtons">
                <input class="createsubmit" type="submit" name="createTask" value="Create task">
                <input class="cancel" type="submit" value="Cancel" name="cancel"></input>
            </div>
        </form>
    
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