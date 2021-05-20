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
	
}else if($confirm['Checkr_Status'] != "Approved" || $confirm['DOB'] == '0000-00-00'){
	echo'<script>
	window.location = "backgroundcheck.php";
	</script>';
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
    
    
    .smarty-suggestion{
    
    background:#2e3842;
    color:white;
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
			<a href="account.php" style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:12px;">My Account</h3></a>
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


			
			echo'	<section  style=" height:auto; ">
				<div class="inner" style="padding:10%;  height:auto;">';
			

    
							
		

							

	
	
	echo'<div class="container">
									<header class="major">
									
							</header>
							';
	
	
	
	
						//	echo'<span  style="text-align:center;"  class="image avatar"><a href="account.php"><img src="'.$profilepic.'" style="width:150px;" alt="" /></a></span>';
							
							if(isset($_SESSION['accountf'])){
								
								echo'<h4>'.$_SESSION['accountf'].'</h4>';
								
								unset($_SESSION['accountf']);
							}
							
						echo'	<form method="post" id="myForm2" name="write"  enctype="multipart/form-data" onSubmit="myvalFunction()"   action="Backend/updateaccountinfo.php">';
						
						$sql = "SELECT * FROM users_socialdriver WHERE username = '".$_SESSION['username']."' ";
						$ss= mysqli_query($mysqli, $sql);
						
						if($ss->num_rows == 0){
						
							   echo' <input type="file" style="display:none;" name="fileToUpload" id="fileToUpload" >
							   ';

						}
							   
						$sql = "SELECT * FROM users_socialdriver WHERE username = '".$_SESSION['username']."' ";
						$confirm2= mysqli_query($mysqli, $sql);
						
						
						if($confirm2->num_rows == 0){
							
						
							    echo'Username: <input type="text" name="username" value="'.$row['username'].'" required><br>';
							    
						}else{
							
							echo'<input type="hidden" name="username " value="'.$row['username'].'">';
							
						}
							    
echo'Email: <input type="email" name="email" value="'.$row['email'].'" required><br>';
							    		

							    echo'Phone (10 digits - numbers only): <input type="number" name="phone" value="'.$row['Phone'].'" min="1000000000" max="9999999999" style="width:200px; color:black;" required><br><br>
							    <table>   <tr style="border:none; background:rgba(0,0,0,0);"><td><input style="font-size:70%;" type="submit" value="Save" >
			
							    
							</form></td>';
							    
							 
							    
							    //start password change
							    
							    $sqlpass = "SELECT * FROM users_socialdriver WHERE username = '".$_SESSION['username']."' ";
							    $resultpass = mysqli_query($mysqli, $sqlpass);
							    
							    
							    
							    
							    if($resultpass->num_rows == 0){
							    
						echo'<td><a class="button" style="font-size:70%;"  onClick="showpassdiv2()">Change Password</a></td></table>';


						if(isset($_SESSION['passwordmess'])){
							
							if($_SESSION['passwordmess'] == "Your password was updated successfully!"){
							echo'<h4 style="color:green;">'.$_SESSION['passwordmess'].'</h4>';
							}else{
								
								echo'<h4 style="color:red;">'.$_SESSION['passwordmess'].'</h4>';
							}
							
							
							
							unset($_SESSION['passwordmess']);
						}
						
						
echo'<script>

function showpassdiv2(){

document.getElementById("passdiv").style.display = "block";
}


function review(){

 var newpass = document.getElementById("newpass").value;
var cnewpass = document.getElementById("cnewpass").value;

if(newpass != cnewpass){
alert("Passwords do not match. Please confirm your new password.");
event.preventDefault();

return false;
}

}

</script>
<div id="passdiv" style="display: none;">
<form action="LoginSystem-CodeCanyon/updatepasswordsecured.php" method="post" onsubmit="review()">
Old Password:
<input type="password" placeholder="Old Password" name="oldpassword" required>
New Password:
<input type="password" placeholder="New Password" id="newpass" name="password" required>
Confirm Password:
<input type="password" placeholder="Confirm New Password" id="cnewpass" name="cpassword" required><br>
<input type="submit">
</form>
</div>
';

}else{
	
	
	echo'</tr></table>';
	
	
}

			//end password change				    



echo'
<div id="transferdiv" style="border-top:solid; border-bottom:solid; margin-bottom:10%;">';
       		
					
       		
       		
echo'<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<form  method="POST"  action="Backend/transferbank.php">



<ul class="actions" >
<li style="text-align:left; padding:0; margin:0;"><br><h2>Balance: $'.$row['Balance'].'</h2></li>
		<li style="text-align:left; padding:0; margin:0;">
		'.$contactinf['Name'].'\'s minimum payout is $50.
</li>
<br>
<li style="display:inline; font-weight:bold;  vertical-align:middle; padding:0; text-align:left;"<h3>Transfer to your Stripe Payment account</h3><table><tr style="border:none; background:rgba(0,0,0,0);"><td style="padding:0; margin:0;">$</td> 
<td style="padding:0; margin:0;"><input type="number" max="'.$row['Balance'].'" min="50" name="ammount" step=".01" value="'.$row['Balance'].'" style="width:100%; color:black;"></td>';
		
		
						
		
						if($row['StripeAccount']!=""){
					echo'<td> <input type="submit" value="Transfer" class="submit-button" style="font-size:70%;"></td>';
						}else{
							echo'<td> <input type="button" value="Transfer" class="submit-button" style="font-size:70%;" onclick="alertstripe()"></td>';
						}
		
						echo'</tr></table></li>';
						
	
						
						if(isset($_SESSION['errmsg'])){
							
							echo'<li style="font-weight:bold; border:solid;">'.$_SESSION['errmsg'].'</br></br></li><br><br>';
							unset($_SESSION['errmsg']);
						}
						
echo'</ul>
		
		
	<script>
function alertstripe(){
		
alert("You must connect a Stripe Payments account to your '.$contactinf['Name'].' account before you  can transfer funds.");
		
}
		
</script>
		
		
</form>
		
</table>
		
		



<table style="padding:0; margin-top:-12%;">
<tr style="border:none; background:rgba(0,0,0,0);"><th colspan="2">Connect a <a href="https://dashboard.stripe.com/register" target="_blank" style="font-weight:bold;">stripe account</a> to transfer funds.</th></tr>
<tr style="border:none; background:rgba(0,0,0,0);">
<td><a class="button"   href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id='.$clientkey['Key'].'&scope=read_write&redirect_uri=https://'.$_SERVER['SERVER_NAME'].'/Drivers/Backend/updatestripeconnect.php">Connect Stripe Account</a></td>

</tr>
</table>



</div>';








							echo'<div id="address">
							<h3>Billing Address</h3>



<form action="Backend/updateaddress.php" method="post"  enctype="multipart/form-data" autocomplete="off">Address:<input type="text" id="street-address" name="street-address" value="'.$row['Address'].'" style="background:white; color:black;" required><br>	
					Unit:<input type="text" id="unit" value="'.$row['Unit'].'" name="unit" style="background:white; color:black;" ><br>	
					City:<input type="text" id="city" name="city" value="'.$row['City'].'" style="background:white; color:black;" required><br>
					State:<input type="text" id="state" value="'.$row['State'].'" name="state" style="background:white; color:black;" required><br>
					Zip:<input type="text" style="color:black;" id="zip" value="'.$row['Zip'].'" name="zip" style="background:white; color:black;" required><br>
					
					
					<input type="submit" value="Save" >
					</form></div>';
								
					
							
							
							echo'<div id="deletediv" style="display:none; padding-top:20%;">
  		
								Are you sure you want to delete your '.$contactinf['Name'].' profile?
								<br><Br>
								<form method="post" action="Backend/deleteaccount.php">
								<input type="hidden" name="ID" value="'.$row['id'].'">
								<input type="submit" value="Delete">
    		
    		
							</form>
    		
    		
								</div>';
					
								
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