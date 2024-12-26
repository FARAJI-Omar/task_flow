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
    private function usernameExists($username) {
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

?>