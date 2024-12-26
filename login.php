<?php
require_once ('connect.php');
require_once ('classes.php');

$db = new database();
$connection = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['username'])) {
        $username = htmlspecialchars(trim($_POST['username']));

        if ($connection) {
            $user = new users($connection);
        
            //check if the username exists in db using the usernameExists method from the users class
            if ($user->usernameExists($username)) {
                session_start();
                $_SESSION['username'] = $username;
                header("Location: home.php");
                exit();

            } else {
                $error_message = "Username does not exist!";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log in</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

</head>
<body class="loginBody">
    <?php include('header.php') ?>
    <div class="login">
        <form action="login.php" method="post">
            <h2>Welcome back</h2>
            <input type="text" name="username" placeholder="Enter your username" required>
            <input type="submit" name="login" value="Log in">
        </form>
        <div class="notRegistered"><p>Not registered yet? <a href="welcome.php">Register</a></p></div>
        <?php if (isset($error_message)): ?>
            <p class="error-message">
                <?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
    <?php include('footer.php') ?>
    
</body>
</html>