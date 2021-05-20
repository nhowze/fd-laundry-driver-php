<?php 



include("LoginSystem-CodeCanyon/cooks.php");

//session_start();

include('LoginSystem-CodeCanyon/db.php');

include_once 'includes/db_connect.php';

include_once 'includes/functions.php';





$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";

$result = mysqli_query($mysqli, $sql);

$row = mysqli_fetch_assoc($result);







$mysqli->query("UPDATE Drivers SET OneSignal = '".$_POST['ID']."' WHERE username = '".$_SESSION['username']."' ");













?>