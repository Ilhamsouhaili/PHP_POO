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

    $nameValue = ""; 
    $priceValue = "";
    $imageValue = "";  
     

    $errorMesage = "";
    $successMesage = "";

if(isset($_POST['add_product'])){

   $nameValue = $_POST['name'];
   $priceValue = $_POST['price'];
   $imageValue = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$imageValue;

   if(empty($nameValue) || empty($priceValue) || empty($imageValue)){

      $errorMesage = "all fileds must be filed out!";

   }else{

     //include product file
    require_once('product.php');

     //create new instance of product class with the values of the inputs
     $product = new Product($nameValue,$priceValue,$imageValue);

     //call the insertProduct method
     $product->insertProduct('products',$connection->conn,$image_folder);

     //give the $successMesage the value of the static $successMsg of the class
     $successMesage = Product::$successMsg;

     //give the $errorMessage the value of the static $errorMsg of the class
     $errorMesage = Product::$errorMsg;
     
     $nameValue = "";

     $successMesage = 'message sent successfully!';
   }

   
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($connection->conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($connection->conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">shop products</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

<div class="box-container">
      <?php

         $connection->selectDatabase('bookdata');
         require_once('product.php');

         //call the static selectAllMessgs method and store the result of the method in $clients
         $prod = Product::selectAllProduct('products',$connection->conn);
         if (is_array($prod) || is_object($prod)){
            foreach($prod as $row) {
               echo " 
               <div class='box'>
                  <img src='uploaded_img/$row[image]' alt=''>
                  <div class='name'>$row[name]</div>
                  <div class='price'>$ $row[price]/-</div>
                  <a href='admin_products.php?update=$row[id]' class='option-btn'>update</a>
                  <a href='admin_delete_products.php?delete=$row[id]' class='delete-btn' onclick='return confirm(\"delete this product?\");'>delete</a>
               </div>";
            }
         }
      ?>
   </div> 

</section>

<section class="edit-product-form">

      <?php
      $connection->selectDatabase('bookdata');
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($connection->conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
      ?>
         <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
            <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
            <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
            <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
            <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
            <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
            <input type="submit" value="update" name="update_product" class="btn">
            <input type="reset" value="cancel" id="close-update" class="option-btn">
         </form>
         <?php
               }
            }
            }else{
               echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
            }
         ?>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>