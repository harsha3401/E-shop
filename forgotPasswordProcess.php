<?php

require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer; // Import PHPMailer classes into the global namespace 

if(isset($_GET["e"])){

    $email = $_GET["e"];

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' "); // Check if the email exists in the database
    $n = $rs->num_rows;

    if($n == 1){

        $code = uniqid();

        Database::iud("UPDATE `user` SET `verification_code`='".$code."' WHERE `email`='".$email."' "); // Update the verification code in the database

        $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'harshanasandaru65@gmail.com'; // Your gmail
            $mail->Password = 'qyeygjbemyvasiph'; // Your gmail app password
            $mail->SMTPSecure = 'ssl'; // tls
            $mail->Port = 465;
            $mail->setFrom('harshanasandaru65@gmail.com', 'Reset Password'); // Your gmail
            $mail->addReplyTo('harshanasandaru65@gmail.com', 'Reset Password'); // Your gmail
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'eShop Forgot Password Verification Code'; // Subject
            $bodyContent = '<h1 style="color:green">Your Verification Code is '.$code.'</h1>'; // Message body
            $mail->Body    = $bodyContent;

            if(!$mail->send()){
                 echo ("Verification code sending failed");
            }else{
                echo ("Success");
            }

    }else{
        echo("Invalid Email Address");
    }

}





?>