<?php
include_once("LoginSystem-CodeCanyon/cooks.php");
//session_start();

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';



if (isset($_SESSION['login']) || $_SESSION['login'] == true) {
    
    
    echo'<script>window.location.href = "home.php";</script>';
    
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
	echo($plugin['HTML']);

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


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
	    
		<title><?php echo $contactinf['Name']; ?> | Driver Registration</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
		    
		    tr{
		        
		       background: rgba(0,0,0,0) !important;
		       border:none !important;
		        
		    }
		    
		</style>

		
		<script src="moment.js"></script>
		<script>
		function validateForm() {
		    
			var fname = document.forms["myForm"]["fname"].value;
			var lname = document.forms["myForm"]["lname"].value;





		    var pass1 = document.forms["myForm"]["password"].value;
			var pass2 = document.forms["myForm"]["passwordc"].value;
		    var bdate = document.forms["myForm"]["dob"].value;
		  
		    
			var agreement = document.getElementById("agreement");


			if(!agreement.checked){

				alert("You must agree to <?php echo $contactinf['Name']; ?>'s terms and conditions before signing up for an account.");
				return false;
			}
		    
		    if(pass1 != pass2){
		        
		        alert("The passwords must match.");
		        return false;
		    }
		    
		    
		    
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
			<style>
		    
		    input[type="submit"],
	input[type="reset"],
	input[type="button"],
	.button {
	    padding-left:10px !important; 
	    padding-right:10px !important;
	    
	}
		    
		</style>
		<style>
/* The container */
.container2 {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container2 input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container2:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container2 input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container2 input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container2 .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

.checkmark{

background:#C0C0C0;

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
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body class="landing is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
						<header id="header" class="alt" style="position:fixed; background:#2e3842;">
			<a href="register.php" style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:12px;">Create Account</h3></a>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											
											<li><a href="about.php">Home</a></li>
										
											<li><a href="register.php">Create Account</a></li>
											<li><a href="login.php">Log In</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>

			
							<!-- Banner -->
				
					    
					    
					    
					    		<?php
				require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

if($detect->isMobile()) {
			
			echo'	<section  style="height:auto; padding:5%; padding-top:10%;">';
			
			}else{
			
			echo'		<section id="banner" style="height:100%;">';
    
    }
    
    ?>
						<div  style="height:auto;">
							
						<?php 



echo'<div style=" padding:5%; padding-top:0%; text-align:center;">


<header class="major">
								
						
							</header>';
							
							


echo'<img src="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo-transparent.png" style="width:30%; height:auto;" alt="" /><br><br>';


							
							if(isset($_SESSION['errormessage'])){
echo'<h3>'.$_SESSION['errormessage'].'</h3>';



unset($_SESSION['errormessage']);

}
	?><form action="LoginSystem-CodeCanyon/register.php" method="post" name="myForm" id="register_form" enctype="multipart/form-data" onsubmit="return validateForm()">
						    
						   
						        
				<input type="text" name="fname" placeholder="First Name"  required><Br>
				<input type="text" name="lname" placeholder="Last Name" required><Br>	
				
				<input type="text" name="username"  placeholder="Username" id="username" onchange="validate()" required><Br>
				<input type="email" name="email" placeholder="Email" required><Br>
				
				
			
				
				Phone: <input type="number" style="color:black; width:200px;" min="1000000000" max="9999999999" name="phone" required>	<Br><br>
				
				DOB: <input type="date" name="dob" style="color:black; min-width:30%; height:30px; vertical-align:middle;" required><Br><Br>
				
				<input type="password" name="password" placeholder="Password" required><Br>
				
				<input type="password" name="passwordc" placeholder="Confirm Password" required>
						    <Br>
						        
						           <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/legal/delivrmat-terms-conditions.php" target="_blank">Terms & Conditions</a><br>
										   						   <label class="container2" style="display:inline;">
						
  <input type="checkbox"  name="agreement" id="agreement">
  <span class="checkmark"></span> I agree to the following terms and conditions.
</label>
						        
						        
						          <div class="g-recaptcha" data-sitekey="6LeaHHMUAAAAAIRMM2QIa0O66VJO2RtY18oBsXqf" data-callback="enableBtn" ></div>
						        <br>
			 <input type="submit" value="Create Account" id="button1" disabled ><Br>
						    
						</form>
						
														<script>
function enableBtn(){
    document.getElementById("button1").disabled = false;
   }
</script>
						
					
					</div>	
						
						
						
						</div>
					</section>

				<!-- CTA -->
				<!--	<section id="cta" class="wrapper style4">
						<div class="inner">
							<header>
								<h2>Arcue ut vel commodo</h2>
								<p>Aliquam ut ex ut augue consectetur interdum endrerit imperdiet amet eleifend fringilla.</p>
							</header>
							<ul class="actions stacked">
								<li><a href="#" class="button fit primary">Activate</a></li>
								<li><a href="#" class="button fit">Learn More</a></li>
							</ul>
						</div>
					</section> -->

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
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-terms-conditions.php">Terms</a></li>
						</ul>
					</footer>';
					
					
					
					?>

			</div>
			<script>

function validate(){

    var str = document.getElementById("username").value;
str = str.replace(/\s+/g, '-').toLowerCase();

document.getElementById("username").value = str;
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