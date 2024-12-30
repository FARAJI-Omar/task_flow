<?php
    require_once ('connect.php');
    require_once ('classes.php');

    $db = new database();
    $connection = $db->connect();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])){
            $username = htmlspecialchars(trim($_POST['username']));

            $user = new users();
            $user->signInOrRegisterUser($username);
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<?php include('header.php') ?>
       
<div class="video-background">
    <video id="backgroundVideo" autoplay muted loop playsinline>
      <source src="images/stars.mp4" type="video/mp4">
    </video>
  </div>
<div class="welcome">
    <div class="welcometext">
        <h2>Welcome!</h2>
        <h3>Enjoy managing your tasks!</h3>
    </div>
</div>
<div>
  <form action="welcome.php" method="post">
      <div class="welcomeclass">
          <input type="text" name="username" placeholder="Please enter a username" >
          <input type="submit" name="enter" value="Enter">
        </div>
    </form>
</div>




<script src="main.js"></script>
</body>
</html>