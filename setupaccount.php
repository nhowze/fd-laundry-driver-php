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


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);




if($confirm['Address'] == "" || $confirm['City'] == "" || $confirm['State'] == "" || $confirm['Zip'] == ""){
	
	
	echo'<script>
						window.location.href = "setuphomeaddress.php";
			</script>';
	
}else if($confirm['Phone_Confirmed'] == "True" && $confirm['StripeAccount'] != ""){
	
	if($confirm['Checkr_Status'] != "Approved" || $confirm['DOB'] == '0000-00-00'){
	echo'<script>
						window.location.href = "backgroundcheck.php";
			</script>';
	
	}else{

		echo'<script>
		window.location.href = "home.php";
</script>';

	}
	
}

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







if($row["Profile_Pic"] != ""){
	$profilepic = $row["Profile_Pic"];
}else{
	$profilepic ="images/avatar.jpg";
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
	    
		<title><?php echo $contactinf['Name']; ?> | Driver Account</title>
		<meta charset="utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script>

function myvalFunction() {

var file= document.getElementById('fileToUpload').files[0].name;
       var reg = /(.*?)\.(jpg|jpeg|png|gif|GIF|PNG|JPEG|JPG)$/;
       if(!file.match(reg))
       {

event.preventDefault();
    	   alert("Invalid File");
    	   return false;
       }else{

document.getElementById("myForm2").submit();
}






}
</script>
		<style>
		    
		    input[type="submit"],
	input[type="reset"],
	input[type="button"],
	.button {
	    padding-left:10px !important; 
	    padding-right:10px !important;
	    
	}
		    
		      section:first-of-type {
        min-height:400px !important;
        
    }

		</style>
	



	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/5.1/jquery.liveaddress.min.js"></script>
<script>var liveaddress = $.LiveAddress({
	key: "13690045101805762",
	debug: true,
	target: "US",
	addresses: [{
		address1: '#street-address',
		locality: '#city',
		administrative_area: '#state',
		postal_code: '#zip',
		country: '#country'
	}]
});
</script>
		
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
			<div id="page-wrapper">

				<!-- Header -->
				<header id="header" class="alt" style="position:fixed; background:#2e3842;">
			<a href="setupaccount.php" style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:12px;">Setup Account</h3></a>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="setupaccount.php">Setup Account</a></li>
										
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

if($detect->isMobile()) {
			
			echo'	<section  style=" height:auto; ">
				<div class="inner" style="padding:10%;  height:auto;">';
			
			}else{
			
			echo'		<section style=" height:auto; ">
				<div  style="padding:15%; padding-top:0; height:auto;">';
    
    }
    ?>
    
    
    
    
    
    				<?php
						
						
							
							
							
							require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

							

	
	
	echo'<div class="container" style="margin-top:15%;">';
			
							
							if(isset($_SESSION['accountf'])){
								
								echo'<h4>'.$_SESSION['accountf'].'</h4>';
								
								unset($_SESSION['accountf']);
							}
							
							
							
							if($row['Phone_Confirmed'] == "False"){
						
							
							echo'	<h2>Update Phone Number*</h2>
<form method="post" id="myForm2" name="write"  enctype="multipart/form-data"    action="Backend/initialupdatenumber.php">
							 <table><tr style="background:rgba(0,0,0,0); border:none;"> 
							<td style="vertical-align:bottom;">(10 digits - numbers only): <input type="number" name="phone" value="'.$row['Phone'].'"  min="1000000000" max="9999999999" style="width:200px; color:black;" required></td>
							<td style="vertical-align:bottom;">  <input type="submit" value="Save" ></td></tr></table>
		
							</form>';
							
							
							
								
								
								echo'	<h2>Confirm Phone Number*</h2>
<form method="post" id="myForm2" name="write"  enctype="multipart/form-data"    action="Backend/initialconfirmnumber.php">
							 <table><tr style="background:rgba(0,0,0,0); border:none;">
							<th style="vertical-align:bottom;" colspan="2">Enter the code that was send to your phone.</th></tr>
<tr style="background:rgba(0,0,0,0); border:none;"><td><input type="text" name="code"   required></td>
							<td style="vertical-align:bottom;">  <input type="submit" value="Save" ></td></tr>

</table>
							</form>';


								if($row['Phone'] != 0 || $row['Phone'] != ''){
echo'<button onclick="resend()">Resend Code</button><Br><br>';
								
								}	
								
								echo'

<script>
function resend() {

   $.post("Backend/resend.php", {


});

alert("Confirmation Code Sent");
}
</script>


';
								
							}
							
							
							
							if($row['StripeAccount'] == ''){
							
						echo'<h2>Update Stripe Account*</h2>


<table style="padding:0; ">
<tr style="border:none; background:rgba(0,0,0,0);"><th colspan="2">Connect a stripe account to transfer funds.</th></tr>
<tr style="border:none; background:rgba(0,0,0,0);">
<td><a class="button"   href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id='.$clientkey['Key'].'&scope=read_write&redirect_uri=https://'.$_SERVER['HTTP_HOST'].'/Drivers/Backend/initialstripeconnect.php">Connect Stripe Account</a></td>


</tr>
</table>

';

							}
						
echo'</div>';




				
					
								
								?>
    
    


						</div>
					</section>
<script>

function showd(){

	document.getElementById("deletediv").style.display = "block";
	document.getElementById("dbut").style.display = "none";
}




</script>
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
<li><a onclick="showd()" id="dbut" style="cursor:pointer;">Delete Account</a></li>
							<li><a href="http://icitechnologies.com" target="_blank">&copy; ICI Technologies LLC</a></li>
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