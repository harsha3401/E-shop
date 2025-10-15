<?php
require "connection.php";
session_start();

if(isset($_GET["id"])){

    $pid = $_GET["id"];
    $user = $_SESSION["u"]["email"];

    Database::iud("DELETE FROM `invoice` WHERE `product_id`='".$pid."' AND `user_email`='".$user."'"); 
}else{
    Database::iud("DELETE FROM `invoice`"); 
}
echo("Success");
?>