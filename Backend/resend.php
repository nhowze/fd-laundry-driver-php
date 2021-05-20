<?php
include_once("../LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('../LoginSystem-CodeCanyon/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';


$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);




//send sms text for confirmation

$to=$confirm['SMS_Address']."\r\n";
$subject="Confirmation Code";
$body="Your confirmation code is ".$confirm['Phone_Code'];








$mail  = new PHPMailer(); // defaults to using php "mail()"



$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$address = $to;
$mail->AddAddress($to, $confirm['First_Name']);

$mail->Subject    = $subject;


$mail->isHTML(false);
$mail->Body= $body;





if(!$mail->Send()) {
	
	
	
}


?>