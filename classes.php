<?php
class users {
    private $db;
    private $conn;

    // Initialize the database connection
    public function __construct() {
        $this->db = new database();
        $this->conn = $this->db->connect();
    }

    // Method to check if the username already exists
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

    // Method to register a new user
    public function registerUser($username) {
        if (empty($username)) {
            return false;
        }

        // Check if the username already exists
        if ($this->usernameExists($username)) {
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
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    // Method to sign in or register a user
    public function signInOrRegisterUser($username) {
        if ($this->usernameExists($username)) {
            session_start();
            $_SESSION['username'] = $username;

            // Fetch user ID based on username
            $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $_SESSION['user_id'] = $stmt->fetchColumn();

            header("Location: home.php");
            exit();
        } else {
            // If user does not exist, register 
            return $this->registerUser($username);
        }
    }
}


class tasks{
    private $db;
    private $conn;
    protected $title;
    protected $description;
    protected $category;
    protected $status; 
    protected $created_at;
    protected $tasks = [];

    // initialize the database connection
    public function __construct(){
        $this->db = new database();
        $this->conn = $this->db->connect();
    }

    // Setter for title
    public function setTitle($title) {
        $this->title = htmlspecialchars(trim($title));
        if(empty($this->title)){
            echo '<p class="error">Title cannot be empty.<br></p>';
            return false;
        }
        return true; 
    }

      // Setter for description
      public function setDescription($description) {
        $this->description = htmlspecialchars(trim($description));
        if(empty($this->description)){
            echo '<p class="error">Description cannot be empty.<br></p>';
            return false;
        }
        return true;
    }

    // Setter for category
    public function setCategory($category) {
        if(empty($category)){
            echo '<p class="error">Category cannot be empty.<br></p>';
            return false;
        }
        $this->category = $category;
        return true;
    }   


    // method to check if task already exists
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
    public function saveTask() {
        try{
            //check if the task already exists
            if($this->taskExists($this->title)){
                echo '<p>Task with that title already exists.<br></p>';
                return false;
            }
            // check if the user is logged in
            if(!isset($_SESSION['username'])){
                header('Location: welcome.php');
                return false;
            }
            $username = $_SESSION['username'];

            $stmt = $this->conn->prepare("INSERT INTO tasks (title, description, category, username) VALUES (:title, :description, :category, :username)");
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':username', $username);

            $stmt->execute();
            // echo "Task created successfully";
            header("Location: home.php");
            exit();
        } catch (PDOException $e) {
            echo "Error saving task" . "<br>";
            return false;
        }
    }

    // Method to get all tasks
    public function getTasks() {
        try {
            $stmt = $this->conn->prepare("SELECT title, description, category, status, created_at, username FROM tasks");
            $stmt->execute();
            $this->tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching tasks: " . $e->getMessage() . "<br>";
        }
    }

    // // Method to retrieve tasks
    // public function getTaskData() {
    //     return $this->tasks; // Return the tasks as array
    // }

    // Method to get tasks related to a specific user
    public function getUserTasks($username) {

        try {
            $stmt = $this->conn->prepare("SELECT title, description, category, status, created_at, username FROM tasks WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $this->tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching user tasks: " . $e->getMessage() . "<br>";
        }
    }

    // Method to retrieve tasks
    public function getTaskData() {
        return $this->tasks;
    }
}



////////////////////////////////////////////////////////////////////////////////////////////////



class BasicTask extends tasks {
    protected $category = 'Basic';

    public function getCategory() {
        return $this->category;
    }
}

class BugTask extends tasks {
    protected $category = 'Bug';

    public function getCategory() {
        return $this->category;
    }
}

class FeatureTask extends tasks {
    protected $category = 'Feature';

    public function getCategory() {
        return $this->category;
    }
}
    

?>