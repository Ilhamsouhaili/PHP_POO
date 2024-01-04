<?php
class Cart
{
    public $cart_id;
    public $user_id;
    public $cart_quantity;
    public $cart_price;
    public $name;
    public $image;

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($user_id, $name, $cart_price, $cart_quantity, $image)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->cart_price = $cart_price;
        $this->cart_quantity = $cart_quantity;
        $this->image = $image;
    }

    public function insertCart($tableName, $conn)
    {
        $sql = "INSERT INTO $tableName (user_id, name, price, quantity, image)
        VALUES ('$this->user_id', '$this->name', '$this->cart_price', '$this->cart_quantity', '$this->image')";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New record created successfully";
        } else {
            self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    public static function selectAllFromCart($tableName, $conn)
    {
        $sql = "SELECT * FROM $tableName";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        } else {
            self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
            return [];
        }
    }

    public function selectCartById($tableName, $conn, $user_id)
    {
        $sql = "SELECT * FROM $tableName WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null;
        }
    }

    public function updateCart($tableName, $conn, $user_id)
    {
        $sql = "UPDATE $tableName SET 
                name = '$this->name',
                price = '$this->cart_price',
                quantity = '$this->cart_quantity',
                image = '$this->image'
                WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "Record updated successfully";
            header("Location: cart_view.php");
        } else {
            self::$errorMsg = "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>






















<?php



// class Cart{

// public $cart_id;
// public $user_id;
// public $cart_quantity;
// public $cart_price;
// public $name;
// public $image;

// public static $errorMsg = "";
// public static $successMsg="";


// public function __construct($user_id,$name,$cart_price,$cart_quantity,$image){

//     //initialize the attributs of the class with the parameters
//     $this->user_id = $user_id;   
//     $this->name = $name; 
//     $this->cart_price = $cart_price;
//     $this->cart_quantity = $cart_quantity;
//     $this->image = $image;
// }

// public function insertCart($tableName,$conn){

// //insert a cart in the database, and give a message to $successMsg and $errorMsg
//     $sql = "INSERT INTO $tableName (user_id,name,price,quantity,image)
//     VALUES (' $this->user_id',' $this->name','$this->cart_price',' $this->cart_quantity','$this->image')";
//     if (mysqli_query($conn, $sql)) {
//     self::$successMsg= "New record created successfully";

//     } else {
//         self::$errorMsg ="Error: " . $sql . "<br>" . mysqli_error($conn);
//     }

// }

// public static function  selectAllFromCart($tableName,$conn){

// //select * from database, and inset the rows results in an array $data[]
//     $sql = "SELECT * FROM $tableName ";
//             $result = mysqli_query($conn, $sql);
//             if (mysqli_num_rows($result) > 0) {
//             // output data of each row
//             $data=[];
//             while($row = mysqli_fetch_assoc($result)) {
            
//                 $data[]=$row;
//             }
//             return $data;
//         }

// }

// public function selectCartById($tableName,$conn,$user_id){
//     //select a cart by id, and return the row result
//     $select_cart_number = mysqli_query($conn, "SELECT * FROM $tableName WHERE user_id = '$user_id'") or die('query failed');
//     $result = mysqli_query($conn, $select_cart_number);
//     if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     $row = mysqli_fetch_assoc($result);    
//     }
//     return $row;
// }

// static function updateCart($user,$tableName,$conn,$id){
//     //update a client of $id, with the values of $client in parameter
//     //and send the user to read.php
//     $sql = "UPDATE $tableName SET fullname='$user->fullname',email='$user->email' WHERE id='$id'";
//         if (mysqli_query($conn, $sql)) {
//         self::$successMsg= "New record updated successfully";
// header("Location:read.php");
//         } else {
//             self::$errorMsg= "Error updating record: " . mysqli_error($conn);
//         }

// }



         

// }

?>