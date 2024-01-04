<?php
    //include connection file 
    require_once('connection.php');
    
    //create in instance of class Connection
    $connection = new Connection();
  
    //call the selectDatabase method
    $connection->selectDatabase('bookdata');


    $emailValue = "";
    $fullnameValue = "";   
    $passwordValue = "";
    $confpasswordValue = "";
    $userTypeValue = "";

    $errorMesage = "";
    $successMesage = "";

    if(isset($_POST["submit"])){
        $fullnameValue = $_POST["fullName"];
        $emailValue = $_POST["email"];    
        $passwordValue = $_POST["password"];
        $confpasswordValue = $_POST["confpassword"];
        $userTypeValue = $_POST["user_type"];

    if(empty($emailValue) || empty($fullnameValue) || empty($passwordValue) || empty($userTypeValue)){

            $errorMesage = "all fileds must be filed out!";

    }else if(strlen($passwordValue) < 8 ){
        $errorMesage = "password must contains at least 8 char";
    }else if(preg_match("/[A-Z]+/", $passwordValue)==0){
        $errorMesage = "password must contains  at least one capital letter!";
    }else if($passwordValue != $confpasswordValue){
        $errorMesage = "confirm password not matched!";
    }else{
        //include the users file
        include('user.php');

        //create new instance of users class with the values of the inputs
        $user = new User($fullnameValue,$emailValue,$passwordValue,$userTypeValue);

        //call the insertUser method
        $user->insertUser('users',$connection->conn);

        //give the $successMesage the value of the static $successMsg of the class
        $successMesage = User::$successMsg;

        //give the $errorMesage the value of the static $errorMsg of the class
        $errorMesage = User::$errorMsg;

        $emailValue = "";
        $fullnameValue = "";   
    }

        
    }
    if (isset($_POST["login"])) {
        header('location:login.php');
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5 ">

        <h2>SIGN UP</h2>

    <?php

    if(!empty($errorMesage)){
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>$errorMesage</strong>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
  </button>
  </div>";
    }
       ?>

        <br>
        <form method="post">
            <div class="row mb-3">
                    <label class="col-form-label col-sm-1" for="fname">Full Name:</label>
                    <div class="col-sm-6">
                        <input value="<?php echo $fullnameValue ?>" class="form-control" type="text" id="fname" name="fullName">
                    </div>
            </div>            
            <div class="row mb-3 ">
                    <label class="col-form-label col-sm-1" for="email">Email:</label>
                    <div class="col-sm-6">
                        <input value=" <?php echo $emailValue ?>" class="form-control" type="email" id="email" name="email">
                    </div>
            </div>
            <div class="row mb-3 ">
                    <label class="col-form-label col-sm-1" for="password">Password:</label>
                    <div class="col-sm-6">
                        <input  class="form-control" type="password" id="password" name="password" >
                    </div>
            </div>
            <div class="row mb-3 ">
                    <label class="col-form-label col-sm-1" for="password">Confirm Password:</label>
                    <div class="col-sm-6">
                        <input  class="form-control" type="password" id="confpassword" name="confpassword" >
                    </div>
            </div>
            <div class="row mb-3 ">
                    <label class="col-form-label col-sm-1" for="password">Select a user type</label>
                    <div class="col-sm-6">
                        <select name="user_type" class="box">
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
                    </div>
            </div>

            <?php
            if(!empty($successMesage)){
echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>$successMesage</strong>
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
</button>
</div>";
            }
  ?>  
      

            <div class="row mb-3">
                    <div class="offset-sm-1 col-sm-3 d-grid">
                        <button name="submit" type="submit" class=" btn btn-primary">Signup</button>
                    </div>
                    <div class="col-sm-1 col-sm-3 d-grid">                        
                        <button name="login" type="submit" class=" btn btn-primary">Login</button>
                    </div>
            </div>
        </form>

    </div>

</body>
</html>