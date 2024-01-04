<?php
    include('user.php');
    class AuthController {
        private $connection;
        public function __construct($conn) {
            $this->connection = $conn;
        }

       
        
        // Login user
        public function loginUser($email, $password,$connection) {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                if (password_verify($password, $row['password'])) {
                    echo "Password is valid";
                } else {
                   echo "Password is invalid";
                }
            } else {
              echo "No user found";
            }   

        }
    }

    // Create an instance of Connection
    $connection = new Connection();
    // Call the selectDatabase method
    $connection->selectDatabase('bookdata');
    // Create an instance of UserController
    $userController = new AuthController($connection->conn);
   
?>