<?php

include("../LoginSystem-CodeCanyon/cooks.php");

//session_start();

include('../LoginSystem-CodeCanyon/db.php');

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';





$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";

$confirm= mysqli_query($mysqli, $sql);

$confirm= mysqli_fetch_assoc($confirm);







if($confirm['Phone_Code'] == $_POST['code']){

	

	

	

	$mysqli->query("UPDATE Drivers SET Phone_Confirmed = 'True' WHERE username = '".$_SESSION['username']."' ");

	

	

}else{

	



	$_SESSION['accountf'] = "Wrong Code";

	

}









header('Location: ../setupaccount.php');





?>