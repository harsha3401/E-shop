<?php
session_start();
require "connection.php";

if (isset($_GET["ca_num"])) {
    $c_num = $_GET["ca_num"];
    $email = $_SESSION["u"]["email"];

    $ca_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "' ");
    $ca_num = $ca_rs->num_rows;

    if($ca_num == 1){
        echo($ca_num);
    }else{
        echo("0");
    }
    
} else {
    echo ("0");
}
