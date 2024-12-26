<?php
class database {
    private $server = "localhost";
    private $dbname = "taskflow"; 
    private $username = "root";
    private $password = "";
    
    private $conn;
    private $error;
    
    public function connect(){
        try{
            $this->conn = new PDO("mysql:host={$this->server};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection successful!<br>";
            return $this->conn;
            
        }catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo "Connection failed: " . $this->error . "<br>";
            return $this->conn;
        }
    }

    public function getError() {
        return $this->error;
    }
}
?>
