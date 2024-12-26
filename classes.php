<?php
class users{
    private $db;
    private $conn;

    // initialize the database connection
    public function __construct(){
        $this->db = new database();
        $this->conn = $this->db->connect();
    }

    // method to check if the username already exists
    public function usernameExists($username) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchColumn() > 0; // Returns true if username exists
        } catch (PDOException $e) {
            echo "Error checking username: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    // method to register a new user
    public function registerUser($username) {
        if (empty($username)) {
            echo "Username cannot be empty.<br>";
            return false;
        }

        // Check if the username already exists
        if ($this->usernameExists($username)) {
            echo '<p class="duplicateError" >Username already exists. Please choose a different one.<br></p>';
            return false;
        }
    
        try {
            $stmt = $this->conn->prepare("INSERT INTO users (username) VALUES (:username)");
            $stmt->bindParam(':username', $username);

            if ($stmt->execute()) {

                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $this->conn->lastInsertId();
                header("Location: home.php");
                exit();
                // echo $_SESSION['username'];
                // echo "User registered successfully!<br>";

            } else {
                echo "Failed to register user.<br>";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    
}

// Example usage:
// $users = new Users();
// $users->registerUser("new_username1");


class tasks{
    private $db;
    private $conn;

    // initialize the database connection
    public function __construct(){
        $this->db = new database();
        $this->conn = $this->db->connect();
    }

    // method to check if the username already exists
    public function taskExists($title) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM tasks WHERE title = :title");
            $stmt->bindParam(':title', $title);
            $stmt->execute();
            return $stmt->fetchColumn() > 0; // Returns true if task exists
        } catch (PDOException $e) {
            echo "Error checking task: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    // method to save a new task
    public function saveTask($title, $description, $category) {
        try{
            //check if the task already exists
            if($this->taskExists($title)){
                echo '<p class="duplicateError" >Task with that title already exists.<br></p>';
                return false;
            }
            // session_start();
            if(!isset($_SESSION['username'])){
                echo "You need to be logged in to create a task.<br>";
                return false;
            }
            $username = $_SESSION['username'];
            // $user_id = $_SESSION['user_id'] = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare("INSERT INTO tasks (title, description, category, username) VALUES (:title, :description, :category, :username)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':username', $username);
            // $stmt->bindParam(':user_id', $user_id);

            $stmt->execute();
            echo '<p class="created" >Task created successfully.<br></p>';
            header("Location: home.php");
            exit();
        } catch (PDOException $e) {
            echo "Error saving task: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}
    
?>