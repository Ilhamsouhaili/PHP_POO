<?php

//include connection file 
require_once('connection.php');
    
//create in instance of class Connection
$connection = new Connection();

//call the selectDatabase method
$connection->selectDatabase('bookdata');

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> messages </h1>

   <div class="box-container">
      <?php

         $connection->selectDatabase('bookdata');
         require_once('contact.php');

         //call the static selectAllMessgs method and store the result of the method in $mssg
         $mssg = Messg::selectAllMessgs('message',$connection->conn);
         if (is_array($mssg) || is_object($mssg)){
            foreach($mssg as $row) {
               echo " 
               <div class='box'>
                  <p> user id : <span>$row[user_id]</span> </p>
                  <p> name : <span>$row[name]</span> </p>
                  <p> number : <span>$row[number]</span> </p>
                  <p> email : <span>$row[email]</span> </p>
                  <p> message : <span>$row[message]</span> </p>
                  <a href='mssg_delete.php?delete=$row[id]' onclick='return confirm(\"delete this message?\");' class='delete-btn'>delete message</a>
               </div>";
            }
         }
      ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>