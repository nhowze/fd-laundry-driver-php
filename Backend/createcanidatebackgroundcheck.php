<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('../LoginSystem-CodeCanyon/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';


if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) {
	
	if(empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])){
		
		if ( !isset($_SESSION['token'])) {
			
			if ( !isset($_SESSION['fb_access_token'])) {
				
				header('Location: login.php');
				
				exit;
			}
		}
	}
}


$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);



if($confirm['AccType'] == "Test"){
    
    $sqlkey = "SELECT * FROM `Keys` WHERE ID = 15 ";
$key= mysqli_query($mysqli, $sqlkey);
$key= mysqli_fetch_assoc($key);
    
    
}else{
    
    $sqlkey = "SELECT * FROM `Keys` WHERE ID = 16 ";
$key= mysqli_query($mysqli, $sqlkey);
$key= mysqli_fetch_assoc($key);
    
    
}



if($_POST['mname'] == "" || !isset($_POST['mname'])){
    
    $middlebool = true;
    
}else{
    
    
    $middlebool = false;
    
}




define('CHECKR_API_KEY', $key['Key']);

$candidate_params = [
    "first_name" => $confirm['First_Name'],
    "middle_name"=> $_POST['mname'],
    "no_middle_name"=> $middlebool,
    "last_name" => $confirm['Last_Name'],
    "dob" => $confirm['DOB'],
    "ssn" => $_POST['ssn'],
    "phone" => $confirm['Phone'],
    "email" => $confirm['email'],
    "driver_license_number" => $_POST['drivernum'],
    "driver_license_state" => $_POST['driverstate'],
    "zipcode"  => $_POST['driverzip']
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.io/v1/candidates');
curl_setopt($curl, CURLOPT_USERPWD, CHECKR_API_KEY . ":");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($candidate_params));

$json = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

//echo "status:" . $http_status . "\n" . $json . "\n\n";

$response = json_decode($json);


$chekrid= $response->id;

//echo($chekrid);

//echo("UPDATE Drivers SET CheckrID = '".$chekrid."' WHERE id = ".$confirm['id']." ");
$mysqli->query("UPDATE Drivers SET CheckrID = '".$chekrid."', Middle_Name = '".$_POST['mname']."' WHERE id = ".$confirm['id']." ");


header('Location: initialbackgroundcheck.php');


?>
