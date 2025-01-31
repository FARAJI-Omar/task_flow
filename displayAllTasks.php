<?php
    session_start();
    
    if (!isset($_SESSION['username'])) {
        header('Location: welcome.php');
        exit();
    }

    require_once('classes.php');
    require_once ('connect.php');

    $allTasks = new tasks();
    $allUsers = $allTasks->getAllUsers();
    $errorMessage = [];
    $errorStatus = [];

    // Handle form submission for assigning tasks
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignTask'])) {
        $taskId = $_POST['taskId'];
        $assignedTo = $_POST['userList'];

        if ($assignedTo == '--Assign Task To:--' || empty($assignedTo)) {
            $errorMessage[$taskId] = "Please select a valid user!";
        } else {
            $allTasks->assignTask($taskId, $assignedTo);
            header('Location: displayAllTasks.php'); 
            exit();
        }
    }

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
            <!-- <h2 class="title">Task List</h2> -->
            <div class="tasks">
                <div class="todotasks">
                <h3 class="title1">To Do</h3>
                    <?php include('todo.php');?>
                </div>
                <div class="inprogresstasks">
                <h3 class="title2">In Progress</h3>
                    <?php include('inprogress.php');?>
                </div>
                <div class="donetasks">
                <h3 class="title3">Done</h3>
                    <?php include('done.php');?>
                </div>
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