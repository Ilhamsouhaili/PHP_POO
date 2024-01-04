<?php

if($_SERVER['REQUEST_METHOD']=='GET'){

    $id=$_GET['delete'];

    //include connection file
    require_once('connection.php');
   

    //create in instance of class Connection
    $connection = new Connection();
  

    //call the selectDatabase method
    $connection->selectDatabase('bookdata');

    //include product file
    require_once('product.php');

    //call the static deleteProduct method
    Product::deleteProduct('products',$connection->conn,$id);

}
?>