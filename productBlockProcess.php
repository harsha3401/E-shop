<?php

require "connection.php";

if(isset($_GET["pid"])){
    
    $p_id = $_GET["pid"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$p_id."'");
    $product_num = $product_rs->num_rows;

    if($product_num == 1){
        
        $product_data = $product_rs->fetch_assoc();

        if($product_data["status_id"] == 1){
            Database::iud("UPDATE `product` SET `status_id`='2' WHERE `id`='".$p_id."'");
            echo("blocked");
        }else if($product_data["status_id"] == 2){
            Database::iud("UPDATE `product` SET `status_id`='1' WHERE `id`='".$p_id."'");
            echo("Unblocked");
        }
        
    }else{
        echo("Cannot find the product. Please try again later.");
    }
    
}else{
   echo("Somthing went wrong");  
}

?>