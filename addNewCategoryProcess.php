<?php
session_start();
require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["email"]) && isset($_POST["name"])) {
    if ($_SESSION["au"]["email"] == $_POST["email"]) {

        $cname = $_POST["name"];
        $umail = $_POST["email"];

        $category_rs = Database::search("SELECT * FROM `category` WHERE `name` LIKE '%" . $cname . "%'");
        $category_num = $category_rs->num_rows;

        if ($category_num == 0) {

            $code = uniqid();

            Database::iud("UPDATE `admin` SET `verification_code`='" . $code . "' WHERE `email`='" . $umail . "'");

            // EMAIL CODE
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ravindumaleesha06270107@gmail.com';
            $mail->Password = 'pfarqgtzucyhmytn';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('ravindumaleesha06270107@gmail.com', 'Admin Verification');
            $mail->addReplyTo('ravindumaleesha06270107@gmail.com', 'Admin Verification');
            $mail->addAddress($umail);
            $mail->isHTML(true);
            $mail->Subject = 'eShop Admin Verification Code for Add New Category';
            $bodyContent = '<h1 style="color:blue">Your Verification Code is : <span style="color:red">' . $code . '</span></h1>';
            $mail->Body    = $bodyContent;

            if (!$mail->send()) {
                echo ("Verification code sending failed");
            } else {
                echo ("Success");
            }
            // EMAIL CODE

        } else {
            echo ("This Category Already Exists");
        }
    } else {
        echo ("Invalid User");
    }
} else {
    echo ("Somthing Missing");
}
