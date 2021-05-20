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
	
}else if($confirm['Phone_Confirmed'] == "False" || $confirm['StripeAccount'] == ""){
	
	
	echo'<script>
						window.location.href = "setupaccount.php";
			</script>';
	
} else if($confirm['Checkr_Status'] != "Approved" || $confirm['DOB'] == '0000-00-00'){
	echo'<script>
	window.location = "backgroundcheck.php";
	</script>';
}

$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


if($row["Profile_Pic"] != ""){
	$profilepic = $row["Profile_Pic"];
}else{
	$profilepic ="images/avatar.jpg";
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



$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_GET['ordernum']."' ";
$result = mysqli_query($mysqli, $sql);
$ordergroup = mysqli_fetch_assoc($result);


$l2Add = $ordergroup['Address_Laundromat'];
$l2City = $ordergroup['City_Laundromat'];
$l2State = $ordergroup['State_Laundromat'];
$l2Zip = $ordergroup['Zip_Laundromat'];

$c2Add = $ordergroup['Address_Customer'];
$c2Unit = $ordergroup['Unit_Customer'];
$c2City = $ordergroup['City_Customer'];
$c2State = $ordergroup['State_Customer'];
$c2Zip = $ordergroup['Zip_Customer'];


$sql = "SELECT * FROM users WHERE id = '".$ordergroup['UserID']."' ";
$result = mysqli_query($mysqli, $sql);
$userinfo = mysqli_fetch_assoc($result);




$sql = "SELECT * FROM Laundromat WHERE ID = '".$ordergroup['Laundromat_ID']."'";
$result = mysqli_query($mysqli, $sql);
$launn = mysqli_fetch_assoc($result);



if($ordergroup['Laundry_Complete'] == 0 ){
    //lat 1 user lat 2 laundromat
    
	$ussaddress = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
    
    	$launaddress = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
    
    $latLong = getLatLong($ussaddress);
$lat1 = $latLong['latitude']?$latLong['latitude']:'Not found';
$long1 = $latLong['longitude']?$latLong['longitude']:'Not found';
    
     $latLong = getLatLong($launaddress);
$lat2 = $latLong['latitude']?$latLong['latitude']:'Not found';
$long2 = $latLong['longitude']?$latLong['longitude']:'Not found';
    



}else if($ordergroup['Laundry_Complete'] == 1 ){
    

 
    //lat 1 laundromat lat 2 user
    
	$ussaddress = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
    
    	$launaddress = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
    
    
        $latLong = getLatLong($launaddress);
$lat1 = $latLong['latitude']?$latLong['latitude']:'Not found';
$long1 = $latLong['longitude']?$latLong['longitude']:'Not found';
    
     $latLong = getLatLong($ussaddress);
$lat2 = $latLong['latitude']?$latLong['latitude']:'Not found';
$long2 = $latLong['longitude']?$latLong['longitude']:'Not found';
    
    
    
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
	    
		<title><?php echo $contactinf['Name']; ?> | Driver Portal </title>
		<meta charset="utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		
 <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src='src/mapbox-gl-traffic.js'></script>
     <link href='src/mapbox-gl-traffic.css' rel='stylesheet' />
    <style>
    body { margin:0; padding:0; }
    #map { width:100%; height:300px;}
    </style>
		
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>

		
		<?php
		
						     if($_SESSION['newlatd'] == "" OR $_SESSION['newlngd'] == ""){
    
    


echo'<script>
$( document ).ready(function() {


setTimeout(function () {
location.reload();

}, 2000);

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
<style>
			    
			    td, th{
			        
			        text-align:left;
			        vertical-align:middle;
			        font-size:auto;
			    }
			    
  section:first-of-type {
        min-height:400px !important;
        
    }
			</style>

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
			<a  style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:2%;">Trip Details</h3></a>
						<nav id="nav">
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

			
				<!-- Three -->
					    	
					    			
					    			<section  style="padding:5%; height:auto;">
				<div class="inner" style="height:auto;">
					    			
					    	
    <?php 
    
    //check if delivery or not
    
    if($ordergroup['Delivery'] == "False"){
    	
    	$ordergroup['DeliveryTotal'] = round($ordergroup['DeliveryTotal'], 2);
    }else{
    $ordergroup['DeliveryTotal'] = round($ordergroup['DeliveryTotal']/2, 2);
    }
    
    $ordergroup['DeliveryTotal'] = number_format($ordergroup['DeliveryTotal'],2);
    
   echo'

									<header class="major" >
									
							</header>
    
            <table style="padding:0; margin:0;">';
            if($confirm['Type'] == "contract"){

echo'<th>Distance</th><th>Total</th>';

            }else{

              echo'<th>Distance</th><th> </th>';

            }


echo'<tr >
<td colspan="2">'.$_GET['intstruction'].'</td>
</tr>
<tr>
<td>Distance: '.$_GET['dur'].' mi</td><td>';

if($confirm['Type'] == "contract"){

echo'Est Total: $'.$ordergroup['Est_total'].'';
}
echo'</td></tr>
</table>


    		<div id="tripdiv">		
    		<form method="get" action="currenttrip.php">
<input type="hidden" name="dur" value="'.$_GET['dur'].'">
<input type="hidden" name="total" value="'.$ordergroup['DeliveryTotal'].'">
<input type="hidden" name="intstruction" value="'.$_GET['intstruction'].'">
<input type="hidden" name="ordernum" value="'.$ordergroup['OrderNum'].'"><br>
<div id="fulltimesearch">';

   if($ordergroup['Status'] != "Driver In Transit" && $ordergroup['Status'] != "Driver In Transit With Laundry"){
echo'<input type="submit" value="Start Trip" style="background:#ed4933;" id="start">';
   }else{
   	
   	echo'<p style="font-weight:bold;">This trip has already been claimed.</p>';
   }

echo'</div></form>		
    </div>



    ';
    

    
  echo"
  <script>
function openDirections() {
  var x = document.getElementById('instructions');
  var y = document.getElementById('directB');
  
    if (x.style.display === 'none') {
        x.style.display = 'block';
        y.innerHTML  = 'Hide Directions';
    } else {
        x.style.display = 'none';
        y.innerHTML  = 'Show Directions';
    }
}
</script>
    
       <div id='map'></div><br>
    <div id='indiv'>
    <button id='directB' onclick='openDirections()'>Show Directions</button>
    <div id='instructions' style='display:none;'><br></div>
    </div>
    <script>
   mapboxgl.accessToken = 'pk.eyJ1Ijoibmhvd3plIiwiYSI6ImNqanN5OHZyNDBkcDEzcG1ydjNubno5bnAifQ.V8BV-Xy-h9sImqVavQ4_sA';
    

    
    var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/traffic-day-v2',
      center: [".$_SESSION['newlngd'].", ".$_SESSION['newlatd']."],
      zoom: 10
    });
    
    map.addControl(new mapboxgl.NavigationControl());
  //  map.addControl(new MapboxTraffic());
    
    
    // this is where the code from the next step will go
    
    map.on('load', function() {
  getRoute();
});

function getRoute() {
  var userloc = [".$_SESSION['newlngd'].", ".$_SESSION['newlatd']."];
  var start = [".$long1.", ".$lat1."];
  var end = [".$long2.", ".$lat2."];
  var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/driving-traffic/' + userloc[0] + ',' + userloc[1] + ';' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?steps=true&geometries=geojson&access_token=' + mapboxgl.accessToken;
  $.ajax({
    method: 'GET',
    url: directionsRequest,
  }).done(function(data) {
    var route = data.routes[0].geometry;
    map.addLayer({
      id: 'route',
      type: 'line',
      source: {
        type: 'geojson',
        data: {
          type: 'Feature',
          geometry: route
        }
      },
      'layout': {
        'line-join': 'round',
        'line-cap': 'round'
      },
      paint: {
        'line-width': 4,
        'line-color': '#439ba3'
      }
    });
    // this is where the code from the next step will go
    
    
    map.addLayer({
  id: 'start',
  type: 'circle',
  source: {
    type: 'geojson',
    data: {
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: start
      }
    }
  }
});
map.addLayer({
  id: 'end',
  type: 'circle',
  source: {
    type: 'geojson',
    data: {
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: end
      }
    }
  }
});
// this is where the JavaScript from the next step will go
    
    var instructions = document.getElementById('instructions');
var steps = data.routes[0].legs[0].steps;
steps.forEach(function(step) {
  instructions.insertAdjacentHTML('beforeend', '<p>' + step.maneuver.instruction + '</p>');
});
    
  });
}
    
    
    </script>
    
    ";
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
          </footer>
          
  
 ';
					
					
					
					?>

			</div>
<?php

      echo'<script> 
$( document ).ready(function() {
  setInterval(function(){ 

 
    $("#fulltimesearch").load("Ajax/startdrive.php?myOrder='.$_GET['ordernum'].'&status='.$ordergroup['Laundry_Complete'].'");
    
    }, 500);
  });


  </script>';

  ?>
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