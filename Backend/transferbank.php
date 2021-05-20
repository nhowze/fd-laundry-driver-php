<?php


include("../LoginSystem-CodeCanyon/cooks.php");

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';



//session_start();





require_once('../includes/stripe-php-master/init.php');



$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

if($row['AccType'] == "Test"){

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 4 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);

$client = "SELECT * FROM `Keys` WHERE `ID` = 17 ";
$clientkey = mysqli_query($mysqli, $client);
$clientkey = mysqli_fetch_assoc($clientkey);


define('CLIENT_ID', $clientkey['Key']);
define('API_KEY', $keys['Key']);

}else{
    
    
    $sql2 = "SELECT * FROM `Keys` WHERE `ID` = 12 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);

$client = "SELECT * FROM `Keys` WHERE `ID` = 18 ";
$clientkey = mysqli_query($mysqli, $client);
$clientkey = mysqli_fetch_assoc($clientkey);


define('CLIENT_ID', $clientkey['Key']);
define('API_KEY', $keys['Key']);
    
    
}



try {



	\Stripe\Stripe::setApiKey($keys['Key']);





	$_POST['ammount'] = $_POST['ammount'] *100;

	

// Create a Transfer to a connected account (later):

$transfer = \Stripe\Transfer::create(array(

		"amount" => $_POST['ammount'],

		"currency" => "usd",

		"destination" => $row['StripeAccount']

		//"transfer_group" => "{ORDER10}",

));



$_POST['ammount'] = number_format(($_POST['ammount'] /100),2);

$_SESSION['errmsg'] = "You have successfully transfered $".$_POST['ammount']." to your stripe account.";







$newbal = $row['Balance']-$_POST['ammount'];



$mysqli->query("UPDATE Drivers SET Balance = '.$newbal.' WHERE username = '".$_SESSION['username']."' ");



//echo("success");







//insert payment history database

$ddate = date("Y-m-d");

$time = date("H:i:s");

$mysqli->query("INSERT INTO Driver_Transfer_History (Username, UserID, Date, Time, Amount) VALUES ('".$_SESSION['username']."', ".$row['id'].", '".$ddate."', '".$time."', ".$_POST['ammount'].") ");











}catch (Exception $e) {

	$error = $e->getMessage();

	

	$_SESSION['errmsg'] = $error; 

	//$_SESSION['errmsg'] = "There waas an error transferring funds to your stripe account. Please check that you have entered the correct stripe account id.";



	//   echo($error);

	

	

	

	

}

//echo($_SESSION['errmsg']);











echo'<script> window.location.href = "../account.php#transferdiv"; </script>';





?>