<?php

class User{

public $id;
public $fullname;
public $email;
public $password;
public $userType;
public $confpassword; 

public static $errorMsg = "";
public static $successMsg="";


public function __construct($fullname,$email,$password,$userType){

    //initialize the attributs of the class with the parameters, and hash the password
    $this->fullname = $fullname;    
    $this->email = $email;
    $this->password = password_hash($password,PASSWORD_DEFAULT);
    $this->userType = $userType;
}

public function insertUser($tableName,$conn){

//insert a user in the database, and give a message to $successMsg and $errorMsg
    $sql = "INSERT INTO $tableName (name,email,password,user_type)
    VALUES ('$this->fullname','$this->email','$this->password','$this->userType')";
    if (mysqli_query($conn, $sql)) {
    self::$successMsg= "New record created successfully";

    } else {
        self::$errorMsg ="Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

static function deleteUser($tableName,$conn,$id){
    //delet a User by his id
    $sql = "DELETE FROM $tableName WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    self::$successMsg= "Record deleted successfully";
    header("Location:admin_users.php");
} else {
    self::$errorMsg= "Error deleting record: " . mysqli_error($conn);
}
  
}
}

?>
