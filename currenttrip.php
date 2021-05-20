<?php
include_once("LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('LoginSystem-CodeCanyon/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


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

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_GET['ordernum']."' ";
$result = mysqli_query($mysqli, $sql);
$ordergroup = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);

if($confirm['id'] != $ordergroup['DriverPickup_ID'] && $ordergroup['DriverPickup_ID'] != 0 && $ordergroup['Laundry_Complete'] == 0){
	
	$_SESSION['alreadyclaimed'] = "Sorry but the trip that you selected has already been claimed by another driver.";
	header('Location: home.php');
	
	
}else if($confirm['id'] != $ordergroup['DriverDeliver_ID'] && $ordergroup['DriverDeliver_ID'] != 0 && $ordergroup['Laundry_Complete'] == 1){
	
	$_SESSION['alreadyclaimed'] = "Sorry but the trip that you selected has already been claimed by another driver.";
	header('Location: home.php');
	
	
}



/**
if(isset($_SESSION['trip'])){
	unset($_SESSION['trip']);
	header("Refresh:0");
	
}else{
	
	$_SESSION['trip'] = true;
	
}
**/

unset($_SESSION['wrongcode']);

$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Twitter' ";
$result = mysqli_query($mysqli, $sql);
$twitter = mysqli_fetch_assoc($result);
$twitter = $twitter['URL'];

$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Facebook' ";
$result = mysqli_query($mysqli, $sql);
$facebook = mysqli_fetch_assoc($result);
$facebook = $facebook['URL'];

$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Google' ";
$result = mysqli_query($mysqli, $sql);
$google = mysqli_fetch_assoc($result);
$google = $google['URL'];


$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Instagram' ";
$result = mysqli_query($mysqli, $sql);
$instagram = mysqli_fetch_assoc($result);
$instagram = $instagram['URL'];


$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Driver' ";
$result = mysqli_query($mysqli, $sql);
$plugin = mysqli_fetch_assoc($result);
$plugin = $plugin['HTML'];



$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


if($confirm['Terms'] != "True"){
	
	
	echo'<script>
window.location.href = "agreement.php";
</script>';
	
	
}else if($confirm['Address'] == "" || $confirm['City'] == "" || $confirm['State'] == "" || $confirm['Zip'] == ""){
	
	
	echo'<script>
						window.location.href = "setuphomeaddress.php";
			</script>';
	
}


if($confirm['Phone_Confirmed'] == "False" || $confirm['StripeAccount'] == ""){
	
	
	echo'<script>
						window.location.href = "setupaccount.php";
			</script>';
	
}


if($confirm['Checkr_Status'] != "Approved" || $confirm['DOB'] == '0000-00-00'){
	echo'<script>
	window.location = "backgroundcheck.php";
	</script>';
}


if($row["Profile_Pic"] != ""){
	$profilepic = $row["Profile_Pic"];
}else{
	$profilepic ="images/avatar.jpg";
}

$_SESSION['ordernum'] = $_GET['ordernum'];



$_GET['total'] = $_GET['total'];



//twilio 


// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once 'includes/twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;


$expiretime = date("c",  strtotime('+24 hours', time()));


// Find your Account Sid and Auth Token at twilio.com/console
$sid    = "ACc9f057b1c506f046dba1e18e89d6e069";
$token  = "6e70b8bb2af1ea27c0e6969c1bd8418f";


$sqlus = "SELECT * FROM users WHERE id = ".$ordergroup['UserID']." ";
$userinf= mysqli_query($mysqli, $sqlus);
$userinf= mysqli_fetch_assoc($userinf);



$sqllan = "SELECT * FROM Laundromat WHERE ID = ".$ordergroup['Laundromat_ID']." ";
$landromatinf= mysqli_query($mysqli, $sqllan);
$landromatinf= mysqli_fetch_assoc($landromatinf);


	
if($ordergroup['Laundry_Complete'] == 0  ){  //Laundry Started Trip Start
	
	
	if($ordergroup['DriverPickup_Username'] != $_SESSION['username']){
		
		$twilio = new Client($sid, $token);
		//User <->  Driver PartnerShip
		
		
		if($ordergroup['Pickup_User_Num'] == 0 || $ordergroup['Pickup_User_Num'] == ''){
			
<<<<<<< HEAD
<<<<<<< HEAD
			$sessiontwilious = $twilio->proxy->v1->services("")
=======
			$sessiontwilious = $twilio->proxy->v1->services("KSe7198a353437eebcd797ffd5c0ac1dfd")
>>>>>>> 1af1fad... 1.0
=======
			$sessiontwilious = $twilio->proxy->v1->services("")
>>>>>>> 8d76903... 1.1
			->sessions
			->create(array(	"uniqueName" => $ordergroup['OrderNum']."driver-user-initial", "dateExpiry" => $expiretime
			));
			
			
			
			
			//first participant
			$participant1 = $twilio->proxy->v1->services($sessiontwilious->serviceSid)
			->sessions($sessiontwilious->sid)
			->participants
			->create("+1".$confirm['Phone'], // identifier
					array("friendlyName" => $_SESSION['username'])
					);
			
			
			//Second Participant
			$participant2 = $twilio->proxy->v1->services($sessiontwilious->serviceSid)
			->sessions($sessiontwilious->sid)
			->participants
			->create("+1".$userinf['Phone'], // identifier
					array("friendlyName" => $ordergroup['Username'])
					);
			
			
		}
		
		
		
		//Laundromat <->  Driver PartnerShip
		
		if($ordergroup['Pickup_Laundromat_Num'] == 0 || $ordergroup['Pickup_Laundromat_Num'] == ''){
			
			
<<<<<<< HEAD
<<<<<<< HEAD
			$sessiontwiliolan = $twilio->proxy->v1->services("")
=======
			$sessiontwiliolan = $twilio->proxy->v1->services("KSe7198a353437eebcd797ffd5c0ac1dfd")
>>>>>>> 1af1fad... 1.0
=======
			$sessiontwiliolan = $twilio->proxy->v1->services("")
>>>>>>> 8d76903... 1.1
			->sessions
			->create(array(	"uniqueName" => $ordergroup['OrderNum']."driver-laundromat-initial", "dateExpiry" => $expiretime
			));
			
			
			
			
			//first participant
			$participant3 = $twilio->proxy->v1->services($sessiontwiliolan->serviceSid)
			->sessions($sessiontwiliolan->sid)
			->participants
			->create("+1".$confirm['Phone'], // identifier
					array("friendlyName" => $_SESSION['username'])
					);
			
			
			//Second Participant
			$participant4 = $twilio->proxy->v1->services($sessiontwiliolan->serviceSid)
			->sessions($sessiontwiliolan->sid)
			->participants
			->create("+1".$landromatinf['Phone'], // identifier
					array("friendlyName" => $ordergroup['Name'])
					);
			
			
		}
		
	
		
		$num1p = $participant1->proxyIdentifier;
		$num2p = $participant3->proxyIdentifier;
		
		$ss = "UPDATE OrderGroup SET Initial_Pickup_Start = NOW(), PU= '".$sessiontwilious->sid."', PL = '".$sessiontwiliolan->sid."', Pickup_User_Num = ".$num1p.", Pickup_Laundromat_Num = ".$num2p.", Status = 'Driver In Transit', DriverPickup_Username = '".$_SESSION['username']."', DriverPickup_ID = '".$row['id']."', PickupFee = '".$_GET['total']."', PickupMiles = '".$_GET['dur']."'  WHERE OrderNum = '".$_GET['ordernum']."' ";

		$mysqli->query($ss);
	}


}

if($ordergroup['Laundry_Complete'] == 1  ){ //Laundry Complete Trip Start
	
	if($ordergroup['DriverDeliver_Username'] != $_SESSION['username']){
	    
		$twilio = new Client($sid, $token);
		//User <->  Driver PartnerShip
		
		
		if($ordergroup['Delivery_User_Num'] == '' || $ordergroup['Delivery_User_Num'] == 0){
			
<<<<<<< HEAD
<<<<<<< HEAD
			$sessiontwilious = $twilio->proxy->v1->services("")
=======
			$sessiontwilious = $twilio->proxy->v1->services("KSe7198a353437eebcd797ffd5c0ac1dfd")
>>>>>>> 1af1fad... 1.0
=======
			$sessiontwilious = $twilio->proxy->v1->services("")
>>>>>>> 8d76903... 1.1
			->sessions
			->create(array(	"uniqueName" => $ordergroup['OrderNum']."driver-user-finished", "dateExpiry" => $expiretime
			));
			
			
			
			
			//first participant
			$participant1 = $twilio->proxy->v1->services($sessiontwilious->serviceSid)
			->sessions($sessiontwilious->sid)
			->participants
			->create("+1".$confirm['Phone'], // identifier
					array("friendlyName" => $_SESSION['username'])
					);
			
			
			//Second Participant
			$participant2 = $twilio->proxy->v1->services($sessiontwilious->serviceSid)
			->sessions($sessiontwilious->sid)
			->participants
			->create("+1".$userinf['Phone'], // identifier
					array("friendlyName" => $ordergroup['Username'])
					);
			
			
		}
		
		
		
		//Laundromat <->  Driver PartnerShip
		
		if($ordergroup['Delivery_Laundromat_Num'] == 0 || $ordergroup['Delivery_Laundromat_Num'] == ''){
			
			
<<<<<<< HEAD
<<<<<<< HEAD
			$sessiontwiliolan = $twilio->proxy->v1->services("")
=======
			$sessiontwiliolan = $twilio->proxy->v1->services("KSe7198a353437eebcd797ffd5c0ac1dfd")
>>>>>>> 1af1fad... 1.0
=======
			$sessiontwiliolan = $twilio->proxy->v1->services("")
>>>>>>> 8d76903... 1.1
			->sessions
			->create(array(	"uniqueName" => $ordergroup['OrderNum']."driver-laundromat-finished", "dateExpiry" => $expiretime
			));
			
			
			
			
			//first participant
			$participant3 = $twilio->proxy->v1->services($sessiontwiliolan->serviceSid)
			->sessions($sessiontwiliolan->sid)
			->participants
			->create("+1".$confirm['Phone'], // identifier
					array("friendlyName" => $_SESSION['username'])
					);
			
			
			//Second Participant
			$participant4 = $twilio->proxy->v1->services($sessiontwiliolan->serviceSid)
			->sessions($sessiontwiliolan->sid)
			->participants
			->create("+1".$landromatinf['Phone'], // identifier
					array("friendlyName" => $ordergroup['Name'])
					);
			
			
		}
		
		$num1p = $participant1->proxyIdentifier;
		$num2p = $participant3->proxyIdentifier;
    $ss = "UPDATE OrderGroup SET Initial_Delivery_Start = NOW(), DU= '".$sessiontwilious->sid."', DL = '".$sessiontwiliolan->sid."', Delivery_User_Num = ".$num1p.", Delivery_Laundromat_Num = ".$num2p.", Status = 'Driver In Transit', DriverDeliver_Username = '".$_SESSION['username']."', DriverDeliver_ID = '".$row['id']."', DeliverFee = '".$_GET['total']."', DeliverMiles = '".$_GET['dur']."'  WHERE OrderNum = '".$_GET['ordernum']."' ";
    
    
    $mysqli->query($ss);
	}
	
}






$sql = "SELECT * FROM Laundromat WHERE ID = '".$ordergroup['Laundromat_ID']."' ";
$result = mysqli_query($mysqli, $sql);
$laundromatinfo = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM users WHERE id = '".$ordergroup['UserID']."' ";
$result = mysqli_query($mysqli, $sql);
$userinfo = mysqli_fetch_assoc($result);


	
	$l2Add = $ordergroup['Address_Laundromat'];
	$l2City = $ordergroup['City_Laundromat'];
	$l2State = $ordergroup['State_Laundromat'];
	$l2Zip = $ordergroup['Zip_Laundromat'];
	
	$c2Add = $ordergroup['Address_Customer'];
	$c2Unit = $ordergroup['Unit_Customer'];
	$c2City = $ordergroup['City_Customer'];
	$c2State = $ordergroup['State_Customer'];
	$c2Zip = $ordergroup['Zip_Customer'];
	$c2Instruct = $ordergroup['Special_Instructions'];

	$ussaddress = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
	$ussaddress2 = $c2Add."<br>".$c2Unit."<br>".$c2City.", ".$c2State."<br> ".$c2Zip;
	if($c2Instruct != ""){
		
		$ussaddress2 = $ussaddress2."<br>".$c2Instruct;
	}
	$launaddress = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
	$launaddress2 = $l2Add."<br> ".$l2City.", ".$l2State."<br> ".$l2Zip;
	
	function getLatLong($address){
		if(!empty($address)){
			//Formatted address
			$formattedAddr = str_replace(' ','+',$address);
			//Send request and receive json data by address
<<<<<<< HEAD
			$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
=======
			$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
>>>>>>> 1af1fad... 1.0
			$output = json_decode($geocodeFromAddr);
			//Get latitude and longitute from json data
			$data['latitude']  = $output->results[0]->geometry->location->lat;
			$data['longitude'] = $output->results[0]->geometry->location->lng;
			
			//Return latitude and longitude of the given address
			if(!empty($data)){
<<<<<<< HEAD
				//echo('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
=======
				//echo('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
>>>>>>> 1af1fad... 1.0
				return $data;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


$latLong = getLatLong($ussaddress);
$uslatitude = $latLong['latitude']?$latLong['latitude']:'Not found';
$uslongitude = $latLong['longitude']?$latLong['longitude']:'Not found';


$latLong2 = getLatLong($launaddress);
$launlatitude = $latLong2['latitude']?$latLong2['latitude']:'Not found';
$launlongitude = $latLong2['longitude']?$latLong2['longitude']:'Not found';








if($uslatitude == 'Not found' || $uslongitude == 'Not found' || $launlatitude == 'Not found' || $launlongitude == 'Not found' ){
	
	
	
	echo'<script>
$( document ).ready(function() {
			
			
setTimeout(function () {
location.reload();
			
}, 100);
			
});
</script>';
	
	
	
		
	}else{
	    
	    
		echo'
<input type="hidden" id="locationid" value="'.$uslatitude.'|'.$uslongitude.'&'.$launlatitude.'|'.$launlongitude.'">
<input type="hidden" id="track" value="'.$ordergroup['Laundry_Complete'].'">
<input type="hidden" id="userlat" value="'.$uslatitude.'">
<input type="hidden" id="userlong" value="'.$uslongitude.'">';
		echo'<input type="hidden" id="laundrylat" value="'.$launlatitude.'">
<input type="hidden" id="laundrylong" value="'.$launlongitude.'">
';
	    
	    
	
	
}



?>
<!DOCTYPE HTML>
<!--
	Spectral by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		 <link rel="icon" 
      type="image/jpg" 
      href="../images/app-logo.png">
	    
		<title><?php echo $ordergroup['Laundry_Complete']; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
		<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 600px;
      }
   
   
     section:first-of-type {
        min-height:400px !important;
        
    }
   
    </style>
		
		<?php
		
						     if($_SESSION['newlatd'] == "" OR $_SESSION['newlngd'] == ""){
    
    


echo'<script>
$( document ).ready(function() {


setTimeout(function () {
location.reload();

}, 100);

});
</script>';
}
		
		

		?>
		
		    <script>


function loadlocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition);




    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
   
    
    $.post("Backend/getlocation.php", {
latitude: position.coords.latitude,
longitude: position.coords.longitude
});
}


</script>


			<!-- Matomo -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//www.icitechnologies.com/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '7']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->

	</head>
	<body class="landing is-preload" onload="loadlocation()">

		<!-- Page Wrapper -->
			<div id="page-wrapper" >

				<!-- Header -->
					<header id="header" class="alt" style="position:fixed; background:#2e3842;">
			<a  style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:2%;">Order #: <?php echo $ordergroup['OrderNum']; ?></h3></a>
						<nav id="nav" >
							<ul>
							    
							   
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="home.php">Home</a></li>
											<li><a href="bonuses.php">Monthly Bonus</a></li>
										<li><a href="recent.php">Recent Trips</a></li>
										
										<li><a href="payments.php">Payment History</a></li>
									
										<li><a href="account.php">Account</a></li>
											<li><a href="logout.php">Logout</a></li>
										</ul>
									</div>
								</li>
							</ul>
							
						</nav>	
					</header>

			<style>
			    
			    td, th{
			        
			        text-align:left;
			        vertical-align:middle;
			    }
			    
			    
			</style>
			
			
		
			
			
				<!-- Three -->
					    		<?php
				require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

if($detect->isMobile()) {
			
			echo'	<section  style="height:auto; " >
				<div class="inner" style="padding:5%; padding-top:10%;  height:auto; min-height:450px; ">';
			
			}else{
			
			echo'		<section >
				<div  style="padding:5%; padding-top:0; height:auto; min-height:450px;">';
    
    }
    
    echo'
    
    	<script>

					 $(function() {
						  $("form.transfer").submit(function(event) {
						  
						  
						    event.preventDefault(); // Prevent the form from submitting via the browser
						    var form = $(this);
						    $.ajax({
						      type: "post",
						      url: "Backend/transfer-items.php",
						      data: form.serialize()
						    }).done(function(data) {
						      // Optionally alert the user of success here...
						   
						$("#loaddiv").load("Ajax/currenttrip.php");

						    }).fail(function(data) {
						      // Optionally alert the user of an error here...
						      
						     
						      
						    });

						  });


						});

						
					</script>
					
					
		
    
    
    
    <div id="loaddiv">';
    
 

    if($ordergroup['Laundry_Complete']== 0 && $ordergroup['Status'] == "Driver In Transit"){ // pickup initial from user
echo'<br>'.$_GET['intstruction'].'<br><br>'.$ussaddress2.'<br>
	<br>
<h2>Confirm laundry pickup from '.$userinfo['First_Name'].'.</h2>
<form class="transfer">
<input type="hidden" name="track" value="1">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="initial">


<input type="hidden" name="code" value="initial"  ><br>
<input type="submit" value="Pickup Laundry">
</form>';
    }else if($ordergroup['Laundry_Complete'] == 0 && $ordergroup['Status'] == "Driver In Transit With Laundry"){ // Drop off laundry at laundromat
	
    	echo'<br>'.$_GET['intstruction'].'<br><br>'.$launaddress2.'<br>
	<br>
<h2>Confirm laundry transfer to '.$ordergroup['Name'].'.</h2>
<form class="transfer">

<input type="hidden" name="track" value="0">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="final">

<input type="text" name="code" required><br>

<input type="submit" value="Transfer">
</form>';
	
	
    }else if($ordergroup['Laundry_Complete']== 1 && $ordergroup['Status'] == "Driver In Transit"){	// Pickup Laundry from laudromat
	
	
	
    	echo'<br>'.$_GET['intstruction'].'<br><br>'.$launaddress2.'<br>
	<br>
<h2>Confirm laundry pickup from '.$ordergroup['Name'].'.</h2>
<form class="transfer">
<input type="hidden" name="track" value="1">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="initial">


<input type="text" name="code" required><br>
<input type="submit" value="Pickup Laundry">
</form>';
    	
	
    }else if($ordergroup['Laundry_Complete'] == 1 && $ordergroup['Status'] == "Driver In Transit With Laundry"){	// Drop off Laundry to user
	
	
    	echo'<br>'.$_GET['intstruction'].'<br><br>'.$ussaddress2.'<br>
	<br>
<h2>Confirm laundry transfer to '.$userinfo['First_Name'].'.</h2>
<form class="transfer">

<input type="hidden" name="track" value="1">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="final">

<input type="text" name="code" required><br>

<input type="submit" value="Transfer">
</form>
'.$userinfo['First_Name'].' isn\'t available for a transfer?<br><br>



<form method="post" action="Backend/dropoff.php" onsubmit="validatedropoff()" enctype="multipart/form-data">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<select name="dropoffLocation" id="dropoffLocation" required>
<option value="">Choose option 	&#8681;</option>
<option value="Doorstep">Leave At Doorstep</option>
<option value="Mailroom">Leave In Mailroom</option>
</select><br>
Take a picture of where you dropped off the laundry items.<br><br>


<table style="width:100%;"><tr style="border:none; background:rgba(0,0,0,0);">
<td style="width:50%; text-align:center; vertical-align:top;">
    <label class="button"  id="capture"  for="fileToUpload" style="box-shadow: none;"><i class="fas fa-camera" style="font-size:30px;"></i></label>
<input type="file" required name="fileToUpload"  style="display:none;"  id="fileToUpload" accept="image/*" capture></td>

<td style="width:50%; text-align:center; vertical-align:top;"><input type="submit" value="Drop off" id="dropoffBB" style="display:none;"></td></tr></table>
</form>';
    
	
    }else if($ordergroup['Laundry_Complete'] == 0 && $ordergroup['Status'] == "Received"){
    	
    	
    	echo'<h2>Your trip has been completed!</h2>
<form method="post" action="finaltransfer.php">
				
    	<input type="hidden" name="track" value="0">
    	<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
				
    			<input type="submit" value="Order Detail">
    			</form>';
    	
    	
    }else if($ordergroup['Laundry_Complete'] == 1 && $ordergroup['Status'] == "Order Complete"){
    	
    	
    	
    	echo'<h2>Your trip has been completed!</h2>
<form method="post" action="finaltransfer.php">
		
    	<input type="hidden" name="track" value="1">
    	<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
		
    			<input type="submit" value="Order Detail">
    			</form>';
    	
    	
    }echo'</div>';

    
    if($ordergroup['Laundry_Complete'] == 0){
    
    
echo'
<table  style="padding:0;">
<tr style="border:none; background:rgba(0,0,0,0);"><td colspan="2" style="text"><h3>Contact</h3></td></tr>
<tr style="border:none;">
<td style="padding:0;"><a class="button" href="tel:'.$ordergroup['Pickup_Laundromat_Num'].'">Laundromat</a></td>
<td style="padding:0;"><a class="button" href="tel:'.$ordergroup['Pickup_User_Num'].'">Customer</a></td>
</tr>
</table>';


    }else if($ordergroup['Laundry_Complete'] == 1){
    	
    	
    	echo'
<table  style="padding:0;">
<tr style="border:none; background:rgba(0,0,0,0);"><td colspan="2" style="text"><h3>Contact</h3></td></tr>
<tr style="border:none;">
<td style="padding:0;"><a class="button" href="tel:'.$ordergroup['Delivery_Laundromat_Num'].'">Laundromat</a></td>
<td style="padding:0;"><a class="button" href="tel:'.$ordergroup['Delivery_User_Num'].'">Customer</a></td>
</tr>
</table>';
    	
    	
    }


    
    
    
    
    echo'<div style="text-align:center;">
				
<button class="button" id="reportbutton" onClick="onReport()">Report Issue</button>
				
<p id="reportheader" style="display:none;">Report Issue</p></div>
				
				
<div id="reportDiv" style="display:none; text-align:center;">
				
<form action="Backend/reportissue.php" method="post" onsubmit="valReport()">
				
				
<input type="hidden" name="OrderID" value="'.$ordergroup['ID'].'">
					
<select name="problem" id="problem" required>
<option value="">Choose Issue</option>
<option value="Damaged Items">Damaged Items</option>
<option value="Missing Items">Missing Items</option>
<option value="Other">Other</option>
<option value="Report Laundromat">Report Customer</option>
<option value="Report Laundromat">Report Laundromat</option>
</select><br>
<input type="submit" style="text-align:center;" value="Report Issue">
</form>
					
					
					
</div>
					
<script>
					
function onReport(){
					
	document.getElementById("reportDiv").style.display = "block";
	document.getElementById("reportbutton").style.display = "none";
	document.getElementById("reportheader").style.display = "block";
}
					
					
</script>
					
					
					
<br><br></div>';
    
    
    

?>


</div>

</section>

		<?php


				echo'	<!-- Footer -->
				<footer id="footer">
						<ul class="icons">
								<li><a href="'.$twitter.'" class="icon fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
							<li><a href="'.$facebook.'" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
							<li><a href="'.$instagram.'" class="icon fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>
						
		<li><a href="mailto:'.$contactinf['Email'].'" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
						</ul>
						<ul class="copyright">
							<li><a href="http://icitechnologies.com" target="_blank">&copy; ICI Technologies LLC</a></li>
<li><a href="https://'.$_SERVER['SERVER_NAME'].'/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a href="https://'.$_SERVER['SERVER_NAME'].'/legal/delivrmat-terms-conditions.php">Terms</a></li>
						</ul>
					</footer>';
					
					
					
					?>

			</div>

		<script>
$("tr")
    .click(function(e){
        
 $(this).find(".submitp").submit();  

    });




function validatedropoff(){
    var dropoff = document.getElementById("dropoffLocation").value;
    if(dropoff == ""){
        event.preventDefault()
        alert("Choose a drop off option.");
        
        return false;
    }



var file= document.getElementById("fileToUpload").files[0].name;
       var reg = /(.*?)\.(jpg|jpeg|png|gif|GIF|PNG|JPEG|JPG)$/;

    

 if(!file.match(reg))
       {

event.preventDefault();
    	   alert("Invalid File");
    	   return false;
       }




}




</script>

<script>


$("#capture").on("click", function(){

	var filel = document.getElementById("fileToUpload").value;
	var droploc = document.getElementById("dropoffLocation").value;
	
if(filel == "" || droploc == ""){
		
		$("#dropoffBB").hide();

	}else{

		$("#dropoffBB").show();
		
	}


		
})


$("#fileToUpload").on("change", function(){


	var filel = document.getElementById("fileToUpload").value;

if(filel == ""){
	document.getElementById("capture").style.border = "none";
	document.getElementById("capture").innerHTML = "<i class=\"fas fa-camera\" style=\"font-size:30px;\"></i>";	
}else{
	document.getElementById("capture").style.border = "solid";
	document.getElementById("capture").style.borderWidth = "2px";
	document.getElementById("capture").innerHTML = "Retake";
}

	
})

$("#dropoffLocation").on("change", function(){

	$("#dropoffBB").hide();
	
	var filel = document.getElementById("fileToUpload").value;
	var droploc = document.getElementById("dropoffLocation").value;
	
if(filel == "" || droploc == ""){
		
		$("#dropoffBB").hide();

	}else{

		$("#dropoffBB").show();


	}
		
})


setInterval(function () {
        // Do Something Here
        // Then recall the parent function to
        // create a recursive loop.
        
	var filel = document.getElementById("fileToUpload").value;
	var droploc = document.getElementById("dropoffLocation").value;
	if(filel == "" || droploc == ""){
		
		$("#dropoffBB").hide();

	}else{

		$("#dropoffBB").show();
		
	}
        
	if(filel == ""){
		document.getElementById("capture").style.border = "none";
		document.getElementById("capture").innerHTML = "<i class=\"fas fa-camera\" style=\"font-size:30px;\"></i>";	
	}else{
		document.getElementById("capture").style.border = "solid";
		document.getElementById("capture").style.borderWidth = "2px";
		document.getElementById("capture").innerHTML = "Retake";
	}
       
    }, 1000);



</script>

<script>
    
    $( document ).ready(function() {

window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}

});
    
</script>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>