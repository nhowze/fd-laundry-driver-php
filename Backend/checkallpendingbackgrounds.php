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




$confirm['AccType'] = "Test";

if($confirm['AccType'] == "Test"){
    
    $sqlkey = "SELECT * FROM `Keys` WHERE ID = 15 ";
$key= mysqli_query($mysqli, $sqlkey);
$key= mysqli_fetch_assoc($key);
    
    
}else{
    
    $sqlkey = "SELECT * FROM `Keys` WHERE ID = 16 ";
$key= mysqli_query($mysqli, $sqlkey);
$key= mysqli_fetch_assoc($key);
    
    
}





define('CHECKR_API_KEY', $key['Key']);


$sql = "SELECT * FROM Drivers WHERE Checkr_Status = 'pending' AND AccType = '".$confirm['AccType']."' LIMIT 1 ";

echo($sql);
$result= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($result);






$report_params = [
    "candidate_id" => $candidate_id,
    "package" => "driver_standard",
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.io/v1/reports/'.$confirm['Checkr_Report_ID']);

echo('https://api.checkr.io/v1/reports/'.$confirm['Checkr_Report_ID']);

curl_setopt($curl, CURLOPT_USERPWD, CHECKR_API_KEY . ":");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, false);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
 
$json = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 
curl_close($curl);
 
echo "status:" . $http_status . "\n" . $json . "\n\n";

$response = json_decode($json);

echo "report_id:" . $response->status;


if($response->status == "clear"){
   
   $response->status == "Approved";
    
}


var_dump($response);

//$mysqli->query("UPDATE Drivers SET Checkr_Report_ID = '".$response->id."', Checkr_Status = '".$response->status."' WHERE id = ".$confirm['id']."");




?>
