<?php

if($_SERVER['REQUEST_METHOD']=='GET'){

    $id=$_GET['delete'];

    //include connection file
    require_once('connection.php');
   

    //create in instance of class Connection
    $connection = new Connection();
  

    //call the selectDatabase method
    $connection->selectDatabase('bookdata');

    //include contact file
    require_once('contact.php');

    //call the static deleteMessg method
    Messg::deleteMssg('message',$connection->conn,$id);

}
?>