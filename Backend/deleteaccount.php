<?php



include("../LoginSystem-CodeCanyon/cooks.php");

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';



//session_start();





	



	$mysqli->query("DELETE FROM Drivers WHERE id = ".$_POST['ID']." ");

//	$mysqli->query("DELETE FROM Driver_Transfer_History WHERE UserID = ".$_POST['ID']." ");

	

	




echo'

<script>

window.location.href = "logout.php";

		

</script>';





?>