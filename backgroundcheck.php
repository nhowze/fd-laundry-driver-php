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
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);



if($row['Terms'] != "True"){
	
	
	echo'<script>
window.location.href = "agreement.php";
</script>';
	
	
}else if($row['Address'] == "" || $row['City'] == "" || $row['State'] == "" || $row['Zip'] == ""){
	
	
	echo'<script>
						window.location.href = "setuphomeaddress.php";
			</script>';
	
}else if($confirm['Checkr_Status'] == "Approved" && ($confirm['Phone_Confirmed'] == "False" || $confirm['StripeAccount'] == "")){
	
	
	echo'<script>
						window.location.href = "setupaccount.php";
			</script>';
	

    
   } else if($row['Checkr_Status'] == "Approved" && $confirm['DOB'] != '0000-00-00'){
	
	
	echo'<script>
						window.location.href = "home.php";
			</script>';
	



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
		
		
				<script src="includes/moment.js"></script>
		<script>
		function validateForm() {
		   
		 
		    var bdate = document.forms["myForm"]["dob"].value;
		  
		  
		    
		    var years = moment().diff(bdate, 'years');


			
			if(years < 18) {
			    
			    alert("You must be at least 18 years old to drive for <?php echo $contactinf['Name']; ?>.");
			    
		     	    return false;
		        }

		    
		}
		
		</script>
		<style>
		    
		    select option { color: black; }
		    
		</style>
		
		
		
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
			<a  style="text-decoration: hidden !important;" href="backgroundcheck.php"><h3 style="text-align:center; padding-top:12px;">Setup Account</h3></a>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="backgroundcheck.php">Setup Account</a></li>
										
											<li><a href="Backend/logout.php">Logout</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>

		
				<!-- Three -->
					    		<?php
				require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;


			
			echo'	<section  style=" height:auto; ">
				<div class="inner" style="padding:10%; padding-top:20%; height:auto; text-align:center; min-height:420px;">


<img src="images/applogo.png" style="max-width:40%;"><br><br>
';			
		
		

			
			if($confirm['DOB'] == '0000-00-00'){
			
			echo'<h2>Enter Date of Birth</h2>

<form action="Backend/savedob.php" method="post" name="myForm" id="register_form" enctype="multipart/form-data" onsubmit="return validateForm()">
						    
				
				DOB: <input type="date" name="dob" style="color:black; min-width:30%; height:30px; vertical-align:middle;" required>
				
				
			 <input type="submit" value="Save" id="button1" >
						    
						</form>
						

';
			
			
			}
			
			
			
			
					if($row['Checkr_Status'] == ""){
				
				
				echo'<h2>Background Check</h2>
				
				
				<form method="post" action="Backend/createcanidatebackgroundcheck.php">
				
			
				
				<table>
				
				<tr style="border:none; background:rgba(0,0,0,0) !important;">
				<td>First:</td>
				<td><input type="text" name="fname"  value="'.$confirm['First_Name'].'" disabled></td>
				</tr>
				
				<tr style="border:none; background:rgba(0,0,0,0) !important;">
				<td>Middle:</td>
				<td><input type="text" name="mname" ></td>
				</tr>
				
				
				<tr style="border:none; background:rgba(0,0,0,0) !important;">
				<td>Last:</td>
				<td><input type="text" name="last" value="'.$confirm['Last_Name'].'" autocomplete="off" disabled></td>
				</tr>
				

		
				
				<tr style="border:none; background:rgba(0,0,0,0) !important;">
				<td>SSN:</td>
				<td><input type="text" name="ssn" id="ssn" onBlur = "ssnFun()" autocomplete="off" required></td>
				</tr>
				<tr style="border:none;  background:rgba(0,0,0,0) !important;">
				<td>Driver License #</td>
				<td><input type="text" name="drivernum" id="drivernum"  autocomplete="off"  required></td><!-- onBlur="driversnumvalid()"-->
				</tr>
				<tr style="border:none;  background:rgba(0,0,0,0) !important;">
				
				<td colspan="2"><select name="driverstate" autocomplete="off" required>
	<option value="">Choose Driver License State</option>
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select></td>
				</tr>
				
				<tr style="border:none;  background:rgba(0,0,0,0) !important;">
				<td>Driver Zip</td>
				<td ><input type="text"  name="driverzip" id="zip" onBlur="zipvalid()" maxlength="5" required></td>
				</tr>
				
				<tr style="border:none;  background:rgba(0,0,0,0) !important;">
				<td colspan="2"><input type="submit" value="Submit" style="width:100%;"></td>
				</tr>
				
				</table>
				
				
				
				</form>
				<Br><br>';
				
				

			}else if($row['Checkr_Status'] == "pending"){         //Pending
			    
			    
			    echo'<script language="javascript">
setInterval(function(){
   window.location.reload(1);
}, 30000);
</script>

Your background check is currently being processed. We\'ll notify you once everything is complete.';
			    
			    
			}
			
			
			
			
			
			
			
			
    

?>
						</div>
					</section>

			<?php

			echo'<form class="user">
			
<input type="hidden" name="user" value="'.$_SESSION['username'].'">
			
			</form>';
			
			

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
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-terms-conditions.php">Terms</a></li>
						</ul>
					</footer>';
					
					
				
				
					
					?>
			</div>



				<script>
				
				
								function zipvalid() { 
                
                //document.getElementById("drivernum").value.replace(/[^\d.-]/g, ''); 
                
                
                var patt = new RegExp("/[^\d.-]/g");
   var x = document.getElementById("zip");
   var res = patt.test(x.value);
   if(!res){
    x.value = x.value
        .match(/\d*/g).join('')
        .match(/(\d{0,3})(\d{0,2})(\d{0,4})/).slice(1).join('')
        .replace(/-*$/g, '');
   }
                
            } 
				
				
				function driversnumvalid() { 
                
                //document.getElementById("drivernum").value.replace(/[^\d.-]/g, ''); 
                
                
                var patt = new RegExp("/[^\d.-]/g");
   var x = document.getElementById("drivernum");
   var res = patt.test(x.value);
   if(!res){
    x.value = x.value
        .match(/\d*/g).join('')
        .match(/(\d{0,3})(\d{0,2})(\d{0,4})/).slice(1).join('')
        .replace(/-*$/g, '');
   }
                
            } 
				
				function ssnFun() {
   var patt = new RegExp("\d{3}[\-]\d{2}[\-]\d{4}");
   var x = document.getElementById("ssn");
   var res = patt.test(x.value);
   if(!res){
    x.value = x.value
        .match(/\d*/g).join('')
        .match(/(\d{0,3})(\d{0,2})(\d{0,4})/).slice(1).join('-')
        .replace(/-*$/g, '');
   }
				}
				
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