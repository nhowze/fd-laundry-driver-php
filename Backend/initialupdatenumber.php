<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();

require_once('../includes/stripe-php-master/init.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';


$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 4 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM Drivers WHERE username = '".$_POST['username']."' AND id <> ".$row['id']." ";
$resultus = mysqli_query($mysqli, $sql);

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);




function lookup_cnam($phonenum) {
	$uname = "nhowze";
	$pname = "93nr3fc4";
	
	$url = "https://api.data24-7.com/v/2.0?user=$uname&pass=$pname&api=T&p1=$phonenum";
	$xml = simplexml_load_file($url) or die("feed not loading");
	
	if($xml->results->result[0]->wless == "y"){
		$smsaddress = $xml->results->result[0]->sms_address;
		
	}else{
		
		$smsaddress = "error";
		
	}
	return($smsaddress);
	
	
}

$answer = lookup_cnam($_POST["phone"]);

if($answer == "error"){
	
	$_SESSION['accountf']= "Error: Please enter a valid mobile number.";
	echo'<script>location.href = "phonec.php";</script>';
	die("Invalid Number");
	
}else{
	
	$sms = $answer;
	$code = rand(100000,999999);
	
	
	
	$mysqli->query("UPDATE Drivers SET Phone= '".$_POST['phone']."', Phone_Confirmed = 'False', SMS_Address = '".$sms."', Phone_Code = '".$code."' WHERE username = '".$_SESSION['username']."' ");
	
	
	
	
	
	//send sms text for confirmation
	
	$to=$sms."\r\n";
	$subject="Confirmation Code";
	$body="Your confirmation code is ".$code;
	
	
	
	$mail  = new PHPMailer(); // defaults to using php "mail()"



$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$address = $to;
$mail->AddAddress($to, $row['First_Name']);

$mail->Subject    = $subject;


$mail->isHTML(false);
$mail->Body= $body;





if(!$mail->Send()) {
	
	
	
}
	
	
	
	
	
	
	
	$_SESSION['accountf'] = "Confirmation Code Sent";
	
	
	
}



					
					header('Location: ../setupaccount.php');
					
?>