<?php
if (!isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit();
}

require_once('classes.php');
require_once('connect.php');

$allTasks = new tasks();
$allTasks->getUserTasksToDo($_SESSION['username']);
$tasks = $allTasks->getTaskData();
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


<div class="tasks">
    <?php foreach ($tasks as $task): ?>
        <div class="taskcart">
            <p><strong>Title:</strong> <?php echo htmlspecialchars($task['title']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($task['category']); ?></p>
            <p><strong>Created by:</strong> <?php echo htmlspecialchars($task['username']); ?></p>
            <p><strong>Created at:</strong> <?php echo htmlspecialchars($task['created_at']); ?></p>

            <!-- Form for assigning the task -->
            <form method="POST">
                <input type="hidden" name="taskId" value="<?php echo $task['task_id']; ?>">
                <select id="userList" name="userList" class="userList">
                    <option>--Assign Task To:--</option>
                    <?php foreach ($allUsers as $user): ?>
                        <option value="<?php echo htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="assignTask" value="Assign" class="assignButton">
                <div class="errorAssign">
                    <?php if (isset($errorMessage[$task['task_id']])): ?>
                        <span><?php echo htmlspecialchars($errorMessage[$task['task_id']]); ?></span>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
</div>