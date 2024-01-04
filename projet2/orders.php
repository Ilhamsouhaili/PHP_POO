<?php

class Orders{

public $id;
public $user_id;
public $name;
public $number;
public $email;
public $method; 
public $adress;
public $total_products;
public $total_price;
public $placed_on;
public $payment_status;     

public static $errorMsg = "";
public static $successMsg="";


public function __construct($user_id,$name,$number,$email,$method,$adress,$total_products,$total_price,$placed_on,$payment_status){

    //initialize the attributs of the class with the parameters, and hash the password
    $this->user_id = $user_id;
    $this->name = $name;
    $this->number = $number;    
    $this->email = $email;
    $this->method = $method;
    $this->adress = $adress;
    $this->total_products = $total_products;
    $this->total_price = $total_price;
    $this->placed_on = $placed_on;
    $this->payment_status = $payment_status;
}

public function insertOrder($tableName,$conn){

//insert a user in the database, and give a message to $successMsg and $errorMsg
    $sql = "INSERT INTO $tableName (user_id,name,number,email,method,adress,total_products,total_price,placed_on,payment_status)
    VALUES ('$this->user_id','$this->name','$this->number','$this->email','$this->method','$this->adress','$this->total_products','$this->total_price','$this->placed_on','$this->payment_status')";
    if (mysqli_query($conn, $sql)) {
    self::$successMsg = "New record created successfully";

    } else {
        self::$errorMsg ="Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

public function updateOrder($tableName, $conn, $orderId) {
    // Update an existing order in the database based on order ID
    $sql = "UPDATE $tableName SET
            user_id = '$this->user_id',
            name = '$this->name',
            number = '$this->number',
            email = '$this->email',
            method = '$this->method',
            adress = '$this->adress',
            total_products = '$this->total_products',
            total_price = '$this->total_price',
            placed_on = '$this->placed_on',
            payment_status = '$this->payment_status'
            WHERE id = '$orderId'";

    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "Record updated successfully";
    } else {
        self::$errorMsg = "Error updating record: " . mysqli_error($conn);
    }
}

public static function getOrderById($tableName, $conn, $orderId) {
    // Retrieve a specific order from the database based on order ID
    $sql = "SELECT * FROM $tableName WHERE id = '$orderId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $orderData = mysqli_fetch_assoc($result);
        return $orderData;
    } else {
        self::$errorMsg = "Order not found";
        return null;
    }
}

public function deleteOrder($tableName, $conn, $orderId) {
    // Delete an order from the database based on order ID
    $sql = "DELETE FROM $tableName WHERE id = '$orderId'";

    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "Record deleted successfully";
    } else {
        self::$errorMsg = "Error deleting record: " . mysqli_error($conn);
    }
}

}

?>
