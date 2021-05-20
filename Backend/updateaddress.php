<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();




$mysqli->query("UPDATE Drivers SET Address = '".$_POST['street-address']."', Unit = '".$_POST['unit']."', City = '".$_POST['city']."', State = '".$_POST['state']."', Zip = '".$_POST['zip']."'
		
		
		
WHERE username = '".$_SESSION['username']."' ");






header('Location: ../account.php');
?>