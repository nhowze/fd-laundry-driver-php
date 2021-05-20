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

 header('Location: apphome.php');

exit;
}
}
}
}

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


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
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);



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




function get_distance_between_points($latitude1, $longitude1, $latitude2, $longitude2) {
$latitude1 = floatval($latitude1);
$longitude1 = floatval($longitude1);
$latitude2 = floatval($latitude2);
$longitude2 = floatval($longitude2);

	$theta = $longitude1 - $longitude2;
	$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	$miles = acos($miles);
	$miles = rad2deg($miles);
	$miles = $miles * 60 * 1.1515;
	$feet = $miles * 5280;
	$yards = $feet / 3;
	$kilometers = $miles * 1.609344;
	$meters = $kilometers * 1000;
	return compact('miles'); 
}



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


//map sql

/**$sql = 
"SELECT * FROM OrderGroup WHERE (Status = 'Approved' AND DATE = DATE(NOW()))
OR (Status = 'Laundry Complete' AND Delivery = 'True' AND DATE = DATE(NOW())  AND Unavailable = 'false' AND Payment_Status = 'Approved')
OR (Status = 'Laundry Complete' AND Delivery = 'True' AND DATE = DATE(NOW()) AND Payment_Status = 'Approved'  AND Unavailable = 'true' AND TIME(NOW())  NOT BETWEEN Delivery_Time AND Delivery_Time2 )
ORDER BY Date, Delivery_Time, Pickup_Time ";
**/

$sql=
"SELECT * FROM OrderGroup WHERE (Status = 'Approved' )
OR (Status = 'Laundry Complete' AND Delivery = 'True'   AND Unavailable = 'false' AND Payment_Status = 'Approved')
OR (Status = 'Laundry Complete' AND Delivery = 'True'  AND Payment_Status = 'Approved'  AND Unavailable = 'true' AND TIME(NOW())  NOT BETWEEN Delivery_Time AND Delivery_Time2 )
ORDER BY Date, Delivery_Time, Pickup_Time ";


$res =	mysqli_query($mysqli, $sql);


// STEP 3: Store the marker info in arrays for each row found
// save the count of markers for later

$mrk_cnt = 0;

while ($obj = $res->fetch_object())  // get all rows (markers)
{
	$row2['Laundromat_ID'] = $obj->Laundromat_ID;
	$row2['UserID'] = $obj->UserID;



	$sql = "SELECT * FROM Laundromat WHERE ID = ".$row2['Laundromat_ID']." ";
	$laundromat= mysqli_query($mysqli, $sql);
	$laundromat= mysqli_fetch_assoc($laundromat);
	
	
	$sql = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
	$customer= mysqli_query($mysqli, $sql);
	$customer= mysqli_fetch_assoc($customer);

	if($confirm['Phone'] != $laundromat['Phone'] && $confirm['Phone'] != $customer['Phone']){
	    
	    
	
	$l2Add = $obj->Address_Laundromat;
	$l2City = $obj->City_Laundromat;
	$l2State = $obj->State_Laundromat;
	$l2Zip = $obj->Zip_Laundromat;
	
	$c2Add = $obj->Address_Customer;
	$c2Unit = $obj->Unit_Customer;
	$c2City = $obj->City_Customer;
	$c2State = $obj->State_Customer;
	$c2Zip = $obj->Zip_Customer;
	
	
	
	$ordernum = $obj->OrderNum;
	$Stat = $obj->Status;
	$deliv = $obj->Delivery;
	$estdur = $obj->Est_Duration;
	$estttotal = $obj->Est_total;
	
	$unn = $obj->Username;
	$unl = $obj->Name;
		$uidd = $obj->UserID;
		

		
	if($Stat== "Approved"){ //pickup from user
		
	
		
		
		$sql22 = "SELECT * FROM users WHERE id = '".$uidd."' ";
	
	$result22 = mysqli_query($mysqli, $sql22);
	$launInfo = mysqli_fetch_assoc($result22);
	$address = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
	$iconur = "images/markericon/bank.png";
	$unam = $obj->Username;
	$tim = $obj->Pickup_Time;
	$tim = date("h:i A", strtotime($tim));
	
	$stats = "Pickup laundry from ".$launInfo['First_Name']." and deliver it to ".$unl.".";
	
	}else if($Stat== "Laundry Complete" && $deliv== "True" ){ // pickup from laundry
		
		$Laundromat_ID = $obj->Laundromat_ID;
		
		$sql21= "SELECT * FROM users WHERE id = '".$uidd."' ";
		
		$result21 = mysqli_query($mysqli, $sql21);
		$usfn = mysqli_fetch_assoc($result21);
		
		
		$sql22 = "SELECT * FROM Laundromat WHERE ID = '".$Laundromat_ID."' ";
		
		$result22 = mysqli_query($mysqli, $sql22);
		$launInfo = mysqli_fetch_assoc($result22);
		$address = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
		$iconur = "images/markericon/laundromat.png";
		$lnam = $obj->Name;
		$tim = $obj->Delivery_Time;
		$tim = date("h:i A", strtotime($tim));
		
		$stats = "Pickup Laundry from ".$unl." and deliver it to ".$usfn['First_Name'].".";
		
		
	}
	
	
	
	$Laundromat_ID = $obj->Laundromat_ID;
	//$stat = "Pickup laundry from ".$launInfo['Username']." and deliver it to ".$launInfo['Name'].".";
	//$stat = "Pickup Laundry from ".$launInfo['Name']."
					//	and deliver it to ".$unn.".";
	
	
	
	//echo($address);
	


	$latLong = getLatLong($address);
	$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
	$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
	
	
	/**echo($latitude);
	echo'<br>';
	echo($longitude);
	echo'<br>';echo'<br>';echo'<br>';echo'<br>';
	**/
	
	if($obj->Delivery =="False" ){
		
		$dtot = round($obj->DeliveryTotal, 2);
		
	}else{
	
	$dtot = $obj->DeliveryTotal / 2;
	
	
	$dtot = round($dtot, 2);
	
	
	}
	
	$dtot= number_format($dtot,2);
	
	
	$distance = get_distance_between_points($latitude, $longitude, $_SESSION['newlatd'], $_SESSION['newlngd']);
	foreach ($distance as $unit => $value) {
		
		
	
	
		$useaddress = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
	
	
	
	
		$lanaddress = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
	
		
		
		
$fromadd = $useaddress;
$toadd = $lanaddress;
$fromadd = urlencode($fromadd);
$toadd = urlencode($toadd);
	
<<<<<<< HEAD
	$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
=======
	$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
>>>>>>> 1af1fad... 1.0

$dataadd2 = json_decode($dataadd2);

$distanceadd2 = 0;
foreach($dataadd2->rows[0]->elements as $roadadd2) {
    $timeadd2 = $roadadd2->duration->value;
    $distanceadd2 += $roadadd2->distance->value;
}

$milesadd2 = $distanceadd2 * 0.000621371;
$milesadd2 = number_format($milesadd2,1);
	
	
		
		
		if($value <= 20){
			
			$valr = round($value,1);
			
			//declare markers
			$lat[$mrk_cnt] = $latitude;  // save the lattitude
			$lng[$mrk_cnt] = $longitude;  // save the longitude
			
			$inf[$mrk_cnt] = "<h4 style='color:black; font-size:90%;'>Distance Away:".$valr." mi<Br>Trip Distance:".$milesadd2." mi<Br>Trip Duration: ".$estdur." mins<br>Est. Total: $".$estttotal."</h4><form method='get' action='drivesession.php'><input type='hidden' name='dur' value='".$milesadd2."'><input type='hidden' name='intstruction' value='".$stats."'><input type='hidden' name='ordernum' value=".$ordernum."><input type='submit' style='background:#ed4933;' value='Start'></form><p style='color:black;'>".$stats."</p>";
			
			
			// save the info-window
		//	$name[$mrk_cnt] = $obj->name;
			
			$img[$mrk_cnt] = $iconur;
			$mrk_cnt++;
			
		}
		
		
	}
	
	
}
	
	// increment the marker counter
}
$res->close();




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
	    
		<title><?php echo $contactinf['Name']; ?> | Driver Home </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		
		
		
		<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 400px;
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
	<body class="landing is-preload" onload="loadlocation()" >
	
<div id="ajaxDiv"> 

</div>
	<script>


	
function updateHours() {
  setInterval(function(){ 
	
	  $("#ajaxDiv").load("Backend/checkdeliveryhours.php");

	  }, 60000);
}


	$( document ).ready(function() {
		
updateHours()
	
	});


</script>

		<!-- Page Wrapper -->
			<div id="page-wrapper" >

				<!-- Header -->
					<header id="header" class="alt" style="position: fixed !important; background:#2e3842;">
			<a href="home.php" style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:12px; "><?php echo $contactinf['Name']; ?></h3></a>
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
											<li><a href="Backend/logout.php">Logout</a></li>
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


			
			echo'	<section  style="height:auto;" >
				<div class="inner" style="padding:0; padding-top:10%;  height:auto;">';


			


echo'<div >';



	echo'<div style="padding-left:5%; padding-right:5%; width:100%; text-align:center;">';
	
	
	if(isset($_SESSION['ReportMessage'])){
		
		echo'<br><br><h4 style="color: green;">'.$_SESSION['ReportMessage'].'</h4>';
		
		
		unset($_SESSION['ReportMessage']);
	}
	
	if(isset($_SESSION['alreadyclaimed'])){
	
	echo'<h4 style="color:red;">'.$_SESSION['alreadyclaimed'].'</h4>';
	unset($_SESSION['alreadyclaimed']);
}
	
if($confirm['Type'] !="contract"){



$sql = "SELECT * FROM OrderGroup WHERE (DriverPickup_Username = '".$_SESSION['username']."' AND Status = 'Driver In Transit' OR Status = 'Driver In Transit With Laundry') OR  (DriverDeliver_Username = '".$_SESSION['username']."' AND Status = 'Driver In Transit' OR Status = 'Driver In Transit With Laundry')";
$result = mysqli_query($mysqli, $sql);
$tresult = mysqli_fetch_assoc($result);

//echo($sql);


if($result->num_rows > 0){   // if have current trip

	$sqld = "SELECT * FROM OrderGroup WHERE (DriverPickup_Username = '".$_SESSION['username']."' OR DriverDeliver_Username = '".$_SESSION['username']."') AND Status LIKE 'Driver In Transit%'  ";
	$result = mysqli_query($mysqli, $sqld);
	
	
	
	
	
	
	
	echo'<table>';
	
	while($row2 = $result->fetch_assoc()) {
		
		
		
		$sql22 = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
		
		$result22 = mysqli_query($mysqli, $sql22);
		$user = mysqli_fetch_assoc($result22);
		
		
		
		if($row2['Laundry_Complete'] == 0){
			
			
			if($row2['Status'] == "Driver In Transit"){
				
				$stat = "Pickup laundry from ".$user['First_Name']." and deliver it to ".$row2['Name'].".";
				
			}else if($row2['Status'] == "Driver In Transit With Laundry"){
				
				
				$stat = "Drop off  ".$user['First_Name']."'s laundry at ".$row2['Name'].".";
				
				
			}
			
			
			
			$mil = $row2['PickupMiles'];
			
			
		} else if($row2['Laundry_Complete'] == 1){
			
			
			
			if($row2['Status'] == "Driver In Transit"){
				
			$stat = "Pickup Laundry from ".$row2['Name']."
							and deliver it to ".$user['First_Name'].".";
			
			}else if($row2['Status'] == "Driver In Transit With Laundry"){
				
				$stat = "Return laundry back to ".$user['First_Name'].".";
				
				
			}
			
			
			$mil = $row2['DeliverMiles'];
		}
		
		
	
	
	$row2['DeliveryTotal'] = $row2['DeliveryTotal'] / 2;
	$row2['DeliveryTotal'] = round($row2['DeliveryTotal'], 2);
	$row2['DeliveryTotal'] = number_format($row2['DeliveryTotal'],2);
	
	echo'<tr style="cursor:pointer;" onclick="submitCurrentForm(this);">
	<form class="submitp"  method="get" action="currenttrip.php">
	
	<input type="hidden" name="dur" value="'.$mil.'">
	<input type="hidden" name="total" value="'.$row2['DeliveryTotal'].'">
	<input type="hidden" name="intstruction" value="'.$stat.'">
	<input type="hidden" name="ordernum" value="'.$row2['OrderNum'].'"><br>
	
	
	
	 <td >
								Instructions: '.$stat.'
								 
								
								<table style="padding:0 !important; margin:0 !important;">
								<tr style="background:rgba(0,0,0,0); border:none;">
								<td>Distance: '.$mil.' mi</td>
								<td>Est. Total: $'.$row2['Est_total'].'</td>
								</tr>
								</table>
								</td>
	</tr></form>';
	
	}
	
	echo'</table>';
	
	}else{ //search for new trip


		echo'<script>
	
		$( document ).ready(function() {
			setInterval(function(){ 



				if($(\'#mytrip\').length == 0){
				$("#tripdiv").load("Ajax/search.php");
			  }else{
				$("#fulltimesearch").remove();
			  }

			  
				}, 4000);
			});
		
		</script><header class="major" style="padding:0; margin:0;">
		<img src="https://'.$_SERVER['SERVER_NAME'].'/images/app-logo-transparent.png" style="width:50px; padding-top:5%;" alt="" /><h2>Searching For Nearby Laundry Trips</h2>
	
	</header>
	<br><br>
	<div id="fulltimesearch">
	<div class="spinner-border text-light" role="status">
	  <span class="sr-only">Loading...</span>
	</div>
	<div id="tripdiv"></div>
	
	</div>';



	}



}else if($confirm['Type'] =="contract"){
	echo'<header class="major" style="padding:0; margin:0;">
								<img src="https://'.$_SERVER['SERVER_NAME'].'/images/app-logo-transparent.png" style="width:50px; padding-top:5%;" alt="" /><h2>Select a Laundry Trip</h2>
		
							</header>';


							

$sql = "SELECT * FROM OrderGroup WHERE (DriverPickup_Username = '".$_SESSION['username']."' AND Status = 'Driver In Transit' OR Status = 'Driver In Transit With Laundry') OR  (DriverDeliver_Username = '".$_SESSION['username']."' AND Status = 'Driver In Transit' OR Status = 'Driver In Transit With Laundry')";
$result = mysqli_query($mysqli, $sql);
$tresult = mysqli_fetch_assoc($result);

//echo($sql);


if($result->num_rows == 0){
echo'<script>


function showmap() {


document.getElementById("listshowing").style.display = "none";
document.getElementById("list").style.display = "none";
document.getElementById("mapdiv").style.display = "block";
document.getElementById("mapshowing").style.display = "block";
}

function showlist() {


document.getElementById("mapdiv").style.display = "none";
document.getElementById("mapshowing").style.display = "none";
document.getElementById("listshowing").style.display = "block";
document.getElementById("list").style.display = "block";
}


</script>

<ul style="list-style-type:none; width:100%; padding:0; margin:0;" id="mapshowing"><li style="display:inline !important;"><button onclick="showlist()">List</button></li><li style="display:inline !important;"><button class="button primary" onclick="showmap()">Map</button><li></ul>
<ul style="list-style-type:none; width:100%; display:none; padding:0; margin:0;" id="listshowing"><li style="display:inline !important;"><button class="button primary" onclick="showlist()">List</button></li><li style="display:inline !important;"><button onclick="showmap()">Map</button><li></ul>';
					
							if($detect->isMobile()) {
								
								echo'</div>';
							
							}
			
echo'<br><div id="mapdiv" >';
?>



<div id="map_canvas" style="padding:3%; "><div id="map" style="color:black; padding:0; margin:0;"></div></div>
   <script src="src/markerclusterer.js"></script>
       <script>


      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

      function initMap() {



        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 12,
          maxZoom: 16,
mapTypeId: google.maps.MapTypeId.ROADMAP

        });



        var infoWindow = new google.maps.InfoWindow({map: map});

       


var markers = [];



<?php
for ($lcnt = 0; $lcnt <= 600 & $lcnt < $mrk_cnt; $lcnt++)
{	
    echo "
    var point$lcnt = new google.maps.LatLng($lat[$lcnt], $lng[$lcnt]);";
    echo "var mrktx$lcnt = \"$inf[$lcnt]\";\n";
	echo "var infowindow$lcnt = new google.maps.InfoWindow({
   			content: mrktx$lcnt
			});";
    echo "




var marker$lcnt = new google.maps.Marker({

     
position: point$lcnt, map: map,

icon: '$img[$lcnt]'


});\n



markers.push(marker$lcnt);


google.maps.event.addListener(marker$lcnt, 
         'click', function() {
                   
   		     infowindow$lcnt.open(map,marker$lcnt);
                     


          });\n



";


  

}





?>



        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
              
              
            
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('My Location');
            





          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
navigator.geolocation.getCurrentPosition(pos);
          });





navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
              
              
            
            };

            
            map.setCenter(pos);





          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
navigator.geolocation.getCurrentPosition(pos);
          });





        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

var mcOptions = {gridSize: 50, maxZoom: 15};
var markerCluster = new MarkerClusterer(map, markers, mcOptions);

     


     
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }



google.maps.event.addDomListener(window, 'load', initialize);


    </script>
    <script async defer
<<<<<<< HEAD
    src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
=======
    src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
>>>>>>> 1af1fad... 1.0
    </script>



<?php
echo'</div>




<div id="list" style="display:none;" style="padding:3%; margin:2%;">


';
					
$sql2=
"SELECT * FROM OrderGroup WHERE (Status = 'Approved' )
OR (Status = 'Laundry Complete' AND Delivery = 'True'   AND Unavailable = 'false' AND Payment_Status = 'Approved')
OR (Status = 'Laundry Complete' AND Delivery = 'True'  AND Payment_Status = 'Approved'  AND Unavailable = 'true' AND TIME(NOW())  NOT BETWEEN Delivery_Time AND Delivery_Time2 )
ORDER BY Date, Delivery_Time, Pickup_Time ";
$result2 = mysqli_query($mysqli, $sql2);
					
					
						if ($result2->num_rows > 0) {
						    
						    
						if($detect->isMobile()) {
						    
						    	echo'<table>
						
						
						';
						    
						}else{
						echo'<table>
						<th>Order Details</th>
						<th>Date/Time</th>
						<th>Distance Away (mi)</th>
						<th>Delivery Total</th>
						';
						}
						while($row2 = $result2->fetch_assoc()) {
							

							$sql = "SELECT * FROM Laundromat WHERE ID = ".$row2['Laundromat_ID']." ";
							$laundromat= mysqli_query($mysqli, $sql);
							$laundromat= mysqli_fetch_assoc($laundromat);
							
							
							$sql = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
							$customer= mysqli_query($mysqli, $sql);
							$customer= mysqli_fetch_assoc($customer);
						
							if($confirm['Phone'] != $laundromat['Phone'] && $confirm['Phone'] != $customer['Phone']){
							
							$l2Add = $row2['Address_Laundromat'];
							$l2City = $row2['City_Laundromat'];
							$l2State = $row2['State_Laundromat'];
							$l2Zip = $row2['Zip_Laundromat'];
							
							$c2Add = $row2['Address_Customer'];
							$c2Unit = $row2['Unit_Customer'];
							$c2City = $row2['City_Customer'];
							$c2State = $row2['State_Customer'];
							$c2Zip = $row2['Zip_Customer'];
							
					
						
							if($row2['Status'] == "Approved"){
								
								$sql22 = "SELECT * FROM users WHERE id = '".$row2['UserID']."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$launInfo = mysqli_fetch_assoc($result22);
								$address = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
								
								
							}else if($row2['Status'] == "Laundry Complete"){
								
								
								$sql22 = "SELECT * FROM Laundromat WHERE ID = '".$row2['Laundromat_ID']."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$launInfo = mysqli_fetch_assoc($result22);
								$address = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
							}
							
							
							
							
							$latLong = getLatLong($address);
							$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
							$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
							
							
							$distance = get_distance_between_points($latitude, $longitude, $_SESSION['newlatd'], $_SESSION['newlngd']);
							foreach ($distance as $unit => $value) {
								
								
								$sql22 = "SELECT * FROM users WHERE id = '".$uidd."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$userad = mysqli_fetch_assoc($result22);
								
								$useaddress = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
								
								$sql22 = "SELECT * FROM Laundromat WHERE ID = '".$Laundromat_ID."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$laundad = mysqli_fetch_assoc($result22);
								
								
								$lanaddress =  $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
								
								
								$fromadd = $useaddress;
								$toadd = $lanaddress;
								$fromadd = urlencode($fromadd);
								$toadd = urlencode($toadd);
								
<<<<<<< HEAD
								$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
=======
								$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
>>>>>>> 1af1fad... 1.0
								
								$dataadd2 = json_decode($dataadd2);
								
								$distanceadd2 = 0;
								foreach($dataadd2->rows[0]->elements as $roadadd2) {
									$timeadd2 = $roadadd2->duration->value;
									$distanceadd2 += $roadadd2->distance->value;
								}
								
								$milesadd2 = $distanceadd2 * 0.000621371;
								$milesadd2 = number_format($milesadd2,1);
								
								
								
								
								if($value <= 20){
							
							
							
						    
						$dat =  date('n-d-Y',strtotime($row2['Date']));
						
						
						if($row2['Status'] == "Approved"){
		
							$sqld = "SELECT * FROM users WHERE id = '".$row2['UserID']."' ";
							$resultd = mysqli_query($mysqli, $sqld);
							$launInfo = mysqli_fetch_assoc($resultd);
							
							
		
							$stat = "Pickup laundry from ".$launInfo['First_Name']." and deliver it to ".$row2['Name'].".";
		
						   $datt =  date('g:i A',strtotime($row2['Pickup_Time'])); 
						   

						    
						   $endl = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;  

						   
						   
$sqla = "SELECT * FROM Laundromat WHERE ID = '".$row2['Laundromat_ID']."' ";
$resulta = mysqli_query($mysqli, $sqla);
$rowa = mysqli_fetch_assoc($resulta);	
					
			    
$froml = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
						   
						   
						   
						   
						   
						   
						}else if($row2['Status'] == "Laundry Complete"){
						
						
						
						
$sqld = "SELECT * FROM Laundromat WHERE ID = '".$row2['Laundromat_ID']."' ";
$resultd = mysqli_query($mysqli, $sqld);
$launInfo = mysqli_fetch_assoc($resultd);
						    
$endl = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;  	



$sqla = "SELECT * FROM users WHERE id = '".$row2['UserID']."' ";
$resulta = mysqli_query($mysqli, $sqla);
$rowa = mysqli_fetch_assoc($resulta);	
					
			    
$froml = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip; 



						
				 $datt =  date('g:i A',strtotime($row2['Delivery_Time'])); 
						 
					
						 $stat = "Pickup Laundry from ".$row2['Name']."
						and deliver it to ".$rowa['First_Name'].".";
						 
						 
						
						}
						
						
						
		
						    
						    
$lat = $_SESSION['newlatd'];
$lng =$_SESSION['newlngd'];
$fromadd = $froml;
$toadd = $endl;
$fromadd = urlencode($fromadd);
$toadd = urlencode($toadd);
<<<<<<< HEAD
$dataadd = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$lat,$lng&destinations=$toadd&language=en-EN&sensor=false&key=");
=======
$dataadd = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$lat,$lng&destinations=$toadd&language=en-EN&sensor=false&key=");
>>>>>>> 1af1fad... 1.0

$dataadd = json_decode($dataadd);

$distanceadd = 0;
foreach($dataadd->rows[0]->elements as $roadadd) {
    $timeadd += $roadadd->duration->value;
    $distanceadd += $roadadd->distance->value;
}

$milesadd = $distanceadd * 0.000621371;
$milesadd = number_format($milesadd,1);

//2nd


<<<<<<< HEAD
$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
=======
$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
>>>>>>> 1af1fad... 1.0

$dataadd2 = json_decode($dataadd2);

$distanceadd2 = 0;
foreach($dataadd2->rows[0]->elements as $roadadd2) {
    $timeadd2 = $roadadd2->duration->value;
    $distanceadd2 += $roadadd2->distance->value;
}

$milesadd2 = $distanceadd2 * 0.000621371;
$milesadd2 = number_format($milesadd2,1);

	$duration = $timeadd2 / 60;					
						
		$duration = ceil($duration);				
		
		
		if($row2['Delivery'] == "False"){
			
			$row2['DeliveryTotal'] = round($row2['DeliveryTotal'], 2);
			
		}else{
			
		$row2['DeliveryTotal'] = round($row2['DeliveryTotal']/ 2, 2);
		
		}
		
		$row2['DeliveryTotal'] = number_format($row2['DeliveryTotal'],2);
		
						
						    
						     echo'
						     <style>
						     td{
						         font-size:85%;
						         
						     }
						     </style>
						     
						     <tr style="cursor:pointer;" onclick="submitForm(this);">
					    <form class="submitp" action="drivesession.php" method="get"  >
<input type="hidden" name="ordernum" value="'.$row2['OrderNum'].'">
<input type="hidden" name="dur" value="'.$duration.'">
<input type="hidden" name="intstruction" value="'.$stat.'">
						    <td >
						    Instructions: '.$stat.'
						     
						    
						    <table style="padding:0 !important; margin:0 !important;">
						    <tr style="background:rgba(0,0,0,0); border:none;">
						    <td>Distance Away: '.$milesadd.' mi</td>
 <td>Distance: '.$milesadd2.' mi</td>
</tr>

<tr style="border:none;">
 <td>Est Duration: '.$row2['Est_Duration'].' mins</td>
						    <td>Est. Total: $'.$row2['Est_total'].'</td>
						    </tr>
						    </table>
						    </td>
						    </form>
						    </tr>';
						    
						    
						    
								
						    
								}	
							}
						}
						}
						
						echo'</table>';
						
						
						
						}else{
						    
						    
						    echo'<div style="padding:2%; margin:2%; text-align:center;">No current trips available right now.</div>';
						    
						}
					
						
}else{   // if have current trip

$sqld = "SELECT * FROM OrderGroup WHERE (DriverPickup_Username = '".$_SESSION['username']."' OR DriverDeliver_Username = '".$_SESSION['username']."') AND Status LIKE 'Driver In Transit%'  ";
$result = mysqli_query($mysqli, $sqld);







echo'<table>';

while($row2 = $result->fetch_assoc()) {
    
	
	
	$sql22 = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
	
	$result22 = mysqli_query($mysqli, $sql22);
	$user = mysqli_fetch_assoc($result22);
	
	
	
	if($row2['Laundry_Complete'] == 0){
		
		
		if($row2['Status'] == "Driver In Transit"){
			
			$stat = "Pickup laundry from ".$user['First_Name']." and deliver it to ".$row2['Name'].".";
			
		}else if($row2['Status'] == "Driver In Transit With Laundry"){
			
			
			$stat = "Drop off  ".$user['First_Name']."'s laundry at ".$row2['Name'].".";
			
			
		}
		
		
		
		$mil = $row2['PickupMiles'];
		
		
	} else if($row2['Laundry_Complete'] == 1){
		
		
		
		if($row2['Status'] == "Driver In Transit"){
			
		$stat = "Pickup Laundry from ".$row2['Name']."
						and deliver it to ".$user['First_Name'].".";
		
		}else if($row2['Status'] == "Driver In Transit With Laundry"){
			
			$stat = "Return laundry back to ".$user['First_Name'].".";
			
			
		}
		
		
		$mil = $row2['DeliverMiles'];
	}
	
	


$row2['DeliveryTotal'] = $row2['DeliveryTotal'] / 2;
$row2['DeliveryTotal'] = round($row2['DeliveryTotal'], 2);
$row2['DeliveryTotal'] = number_format($row2['DeliveryTotal'],2);

echo'<tr style="cursor:pointer;" onclick="submitCurrentForm(this);">
<form class="submitp"  method="get" action="currenttrip.php">

<input type="hidden" name="dur" value="'.$mil.'">
<input type="hidden" name="total" value="'.$row2['DeliveryTotal'].'">
<input type="hidden" name="intstruction" value="'.$stat.'">
<input type="hidden" name="ordernum" value="'.$row2['OrderNum'].'"><br>



 <td >
						    Instructions: '.$stat.'
						     
						    
						    <table style="padding:0 !important; margin:0 !important;">
						    <tr style="background:rgba(0,0,0,0); border:none;">
						    <td>Distance: '.$mil.' mi</td>
						    <td>Est. Total: $'.$row2['Est_total'].'</td>
						    </tr>
						    </table>
						    </td>
</tr></form>';

}

echo'</table>';

}
}						
			echo'</div>';			
						
						
						
								

?>
</div>
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
function updateOrders() {
  setInterval(function(){ 
	
	  location.reload();

	  }, 60000);
}

$( document ).ready(function() {
	updateOrders()
	
});


</script>




		<script>
$("tr")
    .click(function(e){
        
 $(this).find(".submitp").submit();  

    });

</script>

<script>

$( document ).ready(function() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);


    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }




function showPosition(position) {
   

    $.post("Backend/getlocation.php", {
latitude: position.coords.latitude,
longitude: position.coords.longitude
});


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