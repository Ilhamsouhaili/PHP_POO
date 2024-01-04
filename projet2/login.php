<?php
    //include connection file 
    include('connection.php');  
    session_start(); 
    
    //create in instance of class Connection
    $connection = new Connection();
  
    //call the selectDatabase method
    $connection->selectDatabase('bookdata');
   


    $emailValue = "";      
    $passwordValue = "";
    

    $errorMesage = "";
    $successMesage = "";

    if(isset($_POST["login"])){
   
    $emailValue = $_POST["email"];    
    $passwordValue = $_POST["password"];
   
      
    $sql = "SELECT * FROM users WHERE email = '$emailValue'";
            $result = mysqli_query($connection->conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['user_type']=='admin') {
                if (password_verify($passwordValue, $row['password'])) {
                   // Redirect to the dashboard or any other page
                   $_SESSION['admin_name'] = $row['name'];
                   $_SESSION['admin_email'] = $row['email'];
                   $_SESSION['admin_id'] = $row['id'];
                   header('location:admin_home.php');
                } else {
                    $errorMesage = 'incorrect email or password!';
                }
            }elseif($row['user_type'] == 'user'){

                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                
                header('location:home.php');
       
             } else {
                $errorMesage = "No user found";
            }     

    if(empty($emailValue) || empty($passwordValue)){

            $errorMesage = "all fileds must be filed out!";
    }

    }   
    
    if (isset($_POST["submit"])) {
        header('location:register.php');
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="css/style.css">
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