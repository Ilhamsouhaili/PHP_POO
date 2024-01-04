<?php

class Messg{

public $id;
public $user_id;
public $name;
public $email;
public $number;
public $msg;
 

public static $errorMsg = "";
public static $successMsg="";


public function __construct($user_id,$name,$email,$number,$msg){

    //initialize the attributs of the class with the parameters, and hash the password
    $this->user_id = $user_id;
    $this->name = $name;    
    $this->email = $email;
    $this->number = $number;
    $this->msg = $msg;
}

public function insertMsg($tableName,$conn){

//insert a msg in the database, and give a message to $successMsg and $errorMsg
    $sql = "INSERT INTO $tableName (user_id,name,email,number,message)
    VALUES ('$this->user_id','$this->name','$this->email','$this->number','$this->msg')";
    if (mysqli_query($conn, $sql)) {
    self::$successMsg= "sent successfully";

    } else {
        self::$errorMsg ="Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

public static function  selectAllMessgs($tableName,$conn){

    //select all the mssgs from database, and inset the rows results 
        $sql = "SELECT * FROM $tableName ";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $data=[];
                while($row = mysqli_fetch_assoc($result)) {
                
                    $data[]=$row;
                }
                return $data;
            }
    
    }

    static function deleteMssg($tableName,$conn,$id){
        //delete a message by its id, and send the user to admin_contacts.php
        $sql = "DELETE FROM $tableName WHERE id='$id'";
    
    if (mysqli_query($conn, $sql)) {
        self::$successMsg= "Record deleted successfully";
        header("Location:admin_contacts.php");
    } else {
        self::$errorMsg= "Error deleting record: " . mysqli_error($conn);
    }
    
      
        }

}
?>