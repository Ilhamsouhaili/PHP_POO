<?php

class Product{

public $id;
public $name;
public $price;
public $image; 

public static $errorMsg = "";
public static $successMsg="";


public function __construct($name,$price,$image){

    //initialize the attributs of the class with the parameters
    $this->name = $name;    
    $this->price = $price;    
    $this->image = $image;
}

public function insertProduct($tableName, $conn, $image_folder)
{
    $sql = "INSERT INTO $tableName (name, price, image) VALUES ('$this->name', '$this->price', '$this->image')";
    
    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "New record created successfully";

        // Check image size and move the uploaded file
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        if ($image_size > 2000000) {
            self::$errorMsg = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            self::$successMsg = 'Product added successfully!';
        }
    } else {
        self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

public static function  selectAllProduct($tableName,$conn){

//select all products from database, and inset the rows results in an array $data[]

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

static function updateProduct($product,$tableName, $conn, $productId, $updateImage, $updateImageTmpName, $updateOldImage) {
    $sql = "UPDATE $tableName SET
            name = '$product->name',
            price = '$product->price',
            image = '$product->image'
            WHERE id = '$productId'";

    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "Product updated successfully";

        // Check if there's a new image
        if (!empty($updateImage)) {
            $updateImageSize = $_FILES[$updateImage]['size'];
            $updateFolder = 'uploaded_img/' . $updateImage;

            if ($updateImageSize > 2000000) {
                self::$errorMsg = 'Image file size is too large';
            } else {
                // Update the image in the database
                mysqli_query($conn, "UPDATE $tableName SET image = '$updateImage' WHERE id = '$productId'") or die('Query failed');

                // Move the new image to the designated folder
                move_uploaded_file($updateImageTmpName, $updateFolder);

                // Delete the old image
                unlink('uploaded_img/' . $updateOldImage);
            }
        }
    } else {
        self::$errorMsg = "Error updating product: " . mysqli_error($conn);
    }
}

static function deleteProduct($tableName, $conn, $productId) {
    $sql = "DELETE FROM $tableName WHERE id = '$productId'";

    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "Product deleted successfully";
        header("Location:admin_products.php");
    } else {
        self::$errorMsg = "Error deleting product: " . mysqli_error($conn);
    }
}

public static function getProductById($tableName, $conn, $productId) {
    $sql = "SELECT * FROM $tableName WHERE id = '$productId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $productData = mysqli_fetch_assoc($result);
        return $productData;
    } else {
        self::$errorMsg = "Product not found";
        return null;
    }
}  

public static function getProductByName($conn, $productName)
    {
        $sql = "SELECT * FROM products WHERE name = '$productName'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

}

?>
