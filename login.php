<?php
include_once("LoginSystem-CodeCanyon/cooks.php");

//unset($_COOKIE[$cookie_name]);
//session_destroy();

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
	    
		<title><?php echo $contactinf['Name']; ?> | Driver Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		
		
		
		
		
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
	<body class="landing is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
						<header id="header" class="alt" style="position:fixed; background:#2e3842;">
			<a href="login.php" style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:12px;">Login</h3></a>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											
											<li><a href="apphome.php">Home</a></li>
										
											<li><a href="register.php">Create Account</a></li>
											<li><a href="login.php">Log In</a></li>
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

if($detect->isMobile()) {
			
			echo'	<section  style="height:100%;">';
			
			}else{
			
			echo'		<section  style="height:100%;">';
    
    }
    
 




echo'<div >
<div style=" padding:5%; padding-top:0%; text-align:center;">


							<header class="major">
								<h2><br><br></h2>
							
							</header>';
							
echo'<img src="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo-transparent.png" style="width:30%; height:auto;" alt="" /><br><br>';


if(isset($_SESSION['errormessage'])){



echo'<h3>'.$_SESSION['errormessage'].'</h3>';



unset($_SESSION['errormessage']);

}
?>
							<div >
							<form method="post" action="LoginSystem-CodeCanyon/login.php">
										    
										<input type="text" id="inputEmail" name="username" placeholder="Username" required><br>
										  <input type="password" id="inputPassword" name="password" placeholder="Password" required><br>
										   
										    
										    
										 <ul class="actions">
										<li><input type="submit" value="Login"></li>     
										<li><a href="register.php">Create Account</a></li>
										    <li><a href="forgotpassword.php">Forgot Password</a></li>     
										     </ul>
										      <ul class="actions">
										<li><a href="LoginSystem-CodeCanyon/facebook_connect.php" ><img src="LoginSystem-CodeCanyon/img/fb.png" alt="Facebook"></a></li>
										
								<!--     <li>	<a href="" ><img src="LoginSystem-CodeCanyon/img/twitter.png"  alt="Twitter"></a></li>-->
									
									
									<!--	<li><a href="LoginSystem-CodeCanyon/google_connect.php" ><img src="LoginSystem-CodeCanyon/img/gplus.png"  alt="Google"></a></li>-->
									
										   
										    </ul>
										</form>
										
	</div>

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
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-terms-conditions.php">Terms</a></li>
						</ul>
					</footer>';
					
					
					
					?>

			</div>

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