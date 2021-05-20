<?php 


include("../LoginSystem-CodeCanyon/cooks.php");

//session_start();

include('../LoginSystem-CodeCanyon/db.php');

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';





//delivery hours check



$sqldel = "SELECT * FROM Delivery_Hours WHERE ID = 1 ";





$deliveryhours = mysqli_query($mysqli, $sqldel);

$deliveryhours= mysqli_fetch_assoc($deliveryhours);



$datenum = date("w");



if($datenum == 0 || $datenum == 6){ // weekend

	$now = $now = date("H:i:s");

	if($deliveryhours['Weekend_Open'] <= $now && $deliveryhours['Weekend_Close'] >= $now){

		

		$datestatus = "open";

		

	}else{

		

		$datestatus = "closed2";

	}

	

	

	

}else{

	

	$now = $now = date("H:i:s");

	if($deliveryhours['Week_Open'] <= $now && $deliveryhours['Week_Close'] >= $now){

		

		$datestatus = "open";

		

	}else{

		

		$datestatus = "closed2";

	}

	

	

}



if($datestatus == "closed2"){	//delivery hours closed

	

	

	echo'<script>

			

window.location.href = "https://'.$_SERVER['SERVER_NAME'].'/Drivers/closeddeliveryhours.php";

			

	</script>';

	

}











?>