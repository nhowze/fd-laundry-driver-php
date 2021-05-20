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
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


if($row["Profile_Pic"] != ""){
	$profilepic = $row["Profile_Pic"];
}else{
	$profilepic ="images/avatar.jpg";
}



$sql = "SELECT * FROM OrderGroup WHERE ID = ".$_POST['oid']." ";
$result = mysqli_query($mysqli, $sql);
$ordergroup = mysqli_fetch_assoc($result);




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




$sql = "SELECT * FROM Laundromat WHERE ID = '".$ordergroup['Laundromat_ID']."' ";
$result = mysqli_query($mysqli, $sql);
$laundromatinfo = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM users WHERE id = '".$ordergroup['UserID']."' ";
$result = mysqli_query($mysqli, $sql);
$userinfo = mysqli_fetch_assoc($result);


	$ussaddress = $userinfo['Address']." ".$userinfo['City'].", ".$userinfo['State']." ".$userinfo['Zip'];
	

	
	$launaddress = $laundromatinfo['Address']." ".$laundromatinfo['City'].", ".$laundromatinfo['State']." ".$laundromatinfo['Zip'];
	





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
		$data['latitude']  = $output->results[0]->geometry->bounds->southwest->lat;
		$data['longitude'] = $output->results[0]->geometry->bounds->southwest->lng;
		//Return latitude and longitude of the given address
		if(!empty($data)){
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
	    
		<title><?php echo $contactinf['Name']; ?> | Trip Detail</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript" src="http://usmntcenter.com/js/jquery-ui-1.8.21.custom.min.js"></script>
		
		
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
   
    
    $.post("getlocation.php", {
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
			<a  style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:2%;">Trip Details</h3></a>
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
				<div class="inner" style="padding:5%; padding-top:20%;  height:auto; min-height:450px;">';
			
			}else{
			
			echo'		<section >
				<div  style="padding:5%; padding-top:0; height:auto; min-height:450px;">';
    
    }
    
   

    
    
    
    
    $sql2 ="SELECT * FROM OrderGroup WHERE ID = '".$_POST['oid']."' ORDER BY Date, Delivery_Time, Pickup_Time ";
    $result2 = mysqli_query($mysqli, $sql2);
    
    echo'<div style="text-align:center;">';
    if ($result2->num_rows > 0) {
    	
    	
    	
    	
    	
    	while($row2 = $result2->fetch_assoc()) {
    		
    		
    		$sql = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
    		$result = mysqli_query($mysqli, $sql);
    		$userinfo = mysqli_fetch_assoc($result);
    		
$pickuptime = date("m-d-Y g:i A", strtotime($row2['Initial_Pickup_Start']));
$delivertime=date("m-d-Y g:i A", strtotime($row2['Initial_Delivery_Start']));
    		
    		
    		if($row2['DriverPickup_Username'] == $_SESSION['username'] && $_POST['track'] == 0){
    			
    			$pick=	$userinfo['First_Name']." &#8680; ".$row2['Name']."<br>";
    			$pdist = round($row2['PickupMiles'],1);
    			$pfee = round($row2['PickupFee'],2);
    			
    		}
    		
    		
    		if($row2['DriverDeliver_Username'] == $_SESSION['username'] && $_POST['track'] == 1){
    			
    			$deliv =	$row2['Name']." &#8680; ".$userinfo['First_Name']."<br>";
    			$ddist = round($row2['DeliverMiles'],1);
    			$dfee = round($row2['DeliverFee'],2);
    		}
    		
    		
    	
    	
    			if(isset($pick)){
    				echo($pick);
    				echo''.$pickuptime.'<br>';
    				
    				$fee = $pfee;
    				$miles = $pdist;
    				
    			}else if(isset($deliv)){
    				
    				echo($deliv);
    				echo''.$delivertime.'<br>';
    				$fee = $dfee;
    				$miles = $ddist;
    				
    				
    			}
    		
    		
    		
    		echo'</div><br><br><h2 style="text-align:center;">Details</h2>
			
			
<table style="background:rgba(0,0,0,0); padding:0; margin:0;">
<tr style="border:none; background:rgba(0,0,0,0);">
<td style="text-align:center;">Distance: '.$miles.' mi</td>
<td style="text-align:center;">Trip Total: $'.$fee.'</td>
</tr>
</table>
		
		
';
    		echo'
				
				
				

';
    		
    		
    	}
    	
    	
    	
    	echo'</table>';
    	
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

echo($plugin);
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