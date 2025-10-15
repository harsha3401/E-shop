
<?php

session_start();
require "connection.php";

$receiver;
$sender;

$msg_txt = $_POST["t"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");


if (isset($_POST["r"])) {

    $user_email = $_POST["r"];
    $sender = $_SESSION["au"]["email"];

    Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES
    ('" . $msg_txt . "','" . $date . "','0','" . $sender . "','" . $user_email . "')");
    echo ("Success1");
    
} else if (isset($_SESSION["u"])) {

    $receiver = $_SESSION["u"]["email"];

    $a_rs = Database::search("SELECT * FROM `admin`");
    $a_data = $a_rs->fetch_assoc();

    Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES
    ('" . $msg_txt . "','" . $date . "','0','" . $receiver . "','".$a_data["email"]."')");
    echo ("Success2");
}





// if (isset($_SESSION["u"])) {

//     $sender = $_SESSION["u"]["email"];

//     Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES
//     ('" . $msg_txt . "','" . $date . "','0','" . $sender . "','ravindumaleesha077@gmail.com')");
//     echo ("Success1");
// }

// if (isset($_SESSION["au"])) {

//     $sender = $_SESSION["au"]["email"];
//     $receiver = $_POST["r"];

//     Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES
//     ('" . $msg_txt . "','" . $date . "','0','" . $sender . "','" . $receiver . "')");
//     echo ("Success2");
// }


?>
