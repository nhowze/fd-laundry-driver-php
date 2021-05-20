<?php



include("../LoginSystem-CodeCanyon/cooks.php");

//session_start();

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';

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

define('TOKEN_URI', 'https://connect.stripe.com/oauth/token');

define('AUTHORIZE_URI', 'https://connect.stripe.com/oauth/authorize');

if (isset($_GET['code'])) { // Redirect w/ code

	$code = $_GET['code'];

	$token_request_body = array(

			'client_secret' => API_KEY,

			'grant_type' => 'authorization_code',

			'client_id' => CLIENT_ID,

			'code' => $code,

	);

	$req = curl_init(TOKEN_URI);

	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($req, CURLOPT_POST, true );

	curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));

	// TODO: Additional error handling

	$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);

	$resp = json_decode(curl_exec($req), true);

	curl_close($req);

	//	echo $resp['access_token'];

	//	echo($resp['stripe_user_id']);

	

	$mysqli->query("UPDATE Drivers SET StripeAccount = '".$resp['stripe_user_id']."' WHERE username = '".$_SESSION['username']."' ");

	

}







 echo'

 <script>

 window.location.href = "../account.php";

 

 </script>';

 

 







?>