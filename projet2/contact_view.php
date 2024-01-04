<?php
    //include connection file 
    require_once('connection.php');

    //create in instance of class Connection
    $connection = new Connection();
  
    //call the selectDatabase method
    $connection->selectDatabase('bookdata');

    session_start();   
    $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
      header('location:login.php');
   }

    $nameValue = ""; 
    $emailValue = "";  
    $nbrValue = "";
    $msgValue = "";   

    $errorMesage = "";
    $successMesage = "";

    if(isset($_POST['send'])){

    $nameValue = $_POST["name"];
    $emailValue = $_POST["email"];    
    $nbrValue = $_POST["number"];
    $msgValue = $_POST["message"];
   

    if(empty($emailValue) || empty($nameValue) || empty($nbrValue) || empty($msgValue)){

      $errorMesage = "all fileds must be filed out!";

   }else{
      
     //include the contact file
      include('contact.php');

      //create new instance of messg class with the values of the inputs
      $contact = new Messg($user_id,$nameValue,$emailValue,$nbrValue,$msgValue);

      //call the insertMsg method
      $contact->insertMsg('message',$connection->conn);

      //give the $successMesage the value of the static $successMsg of the class
      $successMesage = Messg::$successMsg;

      //give the $errorMessage the value of the static $errorMsg of the class
      $errorMesage = Messg::$errorMsg;

      $emailValue = "";
      $nameValue = "";

      $successMesage = 'message sent successfully!';
   }
 
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include ('header.php'); ?>

<div class="heading">
   <h3>contact us</h3>
   <p> <a href="home.php">home</a> / contact </p>
</div>

<section class="contact">
   <?php

         if(!empty($errorMesage)){
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>$errorMesage</strong>
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
      </button>
      </div>";
         }
   ?>
   <form action="" method="post">
      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box">
      <input type="email" name="email" required placeholder="enter your email" class="box">
      <input type="number" name="number" required placeholder="enter your number" class="box">
      <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

   <?php
   if(!empty($successMesage)){
   echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
   <strong>$successMesage</strong>
   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
   </button>
   </div>";
            }
  ?>  
</section>

<?php include ('footer.php'); ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>