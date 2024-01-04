<?php

//include the connection file
require_once('connection.php');

//create an instance of Connection class
$connection = new Connection();

//call the createDatabase methods to create database "bookdata"
$connection->createDatabase('bookdata');


//create table users
$query1= "
    CREATE TABLE `users` (
    `id` int(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    `user_type` varchar(20) NOT NULL DEFAULT 'user'
  )";
//create table cart
  $query2= "
    CREATE TABLE `cart` (
      `id` int(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `user_id` int(100) NOT NULL,
      `name` varchar(100) NOT NULL,
      `price` int(100) NOT NULL,
      `quantity` int(100) NOT NULL,
      `image` varchar(100) NOT NULL
    )";
// create table message
    $query3= "
    CREATE TABLE `message` (
      `id` int(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `user_id` int(100) NOT NULL,
      `name` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL,
      `number` varchar(12) NOT NULL,
      `message` varchar(500) NOT NULL
    
    )";

// create table orders
    $query4= "
    CREATE TABLE `orders` (
      `id` int(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `user_id` int(100) NOT NULL,
      `name` varchar(100) NOT NULL,
      `number` varchar(12) NOT NULL,
      `email` varchar(100) NOT NULL,
      `method` varchar(50) NOT NULL,
      `address` varchar(500) NOT NULL,
      `total_products` varchar(1000) NOT NULL,
      `total_price` int(100) NOT NULL,
      `placed_on` varchar(50) NOT NULL,
      `payment_status` varchar(20) NOT NULL DEFAULT 'pending'

)";

// create table products
$query5= "
CREATE TABLE `products` (
  `id` int(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
)";
  

//call the selectDatabase method to select the dataproject
$connection->selectDatabase('bookdata');

//call the createTable method to create table with the $query
$connection->createTable($query1);
$connection->createTable($query2);
$connection->createTable($query3);
$connection->createTable($query4);
$connection->createTable($query5);


?>
