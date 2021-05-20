<?php require_once('../couch/cms.php');
include_once("../Drivers/LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once 'includes/functions.php';


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

?><!DOCTYPE HTML>
<!--
	Spectral by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
	 <link rel="icon" 
      type="image/jpg" 
      href="images/applogo.png">
	  <cms:template title='Driver Home' order='9'>

</cms:template>
		<title><?php echo $contactinf['Name']; ?> | Driver</title>
		
		
			<?php 	
		
		echo'
<meta name="description" content="We are seeking drivers who can transport laundry between near by users and laundromats.">
<meta name="application-name" content="'.$contactinf['Name'].'">
<meta name="author" content="ICI Technologies LLC">

 <meta name="keywords" content="drive '.$contactinf['Name'].','.$contactinf['Name'].' driver,become a '.$contactinf['Name'].' driver,register drive '.$contactinf['Name'].',drive for '.$contactinf['Name'].',work for '.$contactinf['Name'].','.$contactinf['Name'].',laundry app,laundry delivery app,laundry delivery,deliver laundry,laundry delivery service,delivery my laundry,laundry service,laundry pickup,pickup my laundry,
laundromat delivery service,laundromat app,laundromat pickup">';  


		$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


echo'<!-- Twitter Card data -->
<meta name="twitter:title" content="'.$contactinf['Name'].' | Driver App" >
<meta name="twitter:card" content="summary" >
<meta name="twitter:site" content="@publisher_handle" >
<meta name="twitter:description" content="We are seeking drivers who can transport laundry between near by users and laundromats." >
<meta name="twitter:creator" content="@author_handle" >
<meta name="twitter:image" content="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo.png" >



<!-- Open Graph data -->
<meta property="og:title" content="'.$contactinf['Name'].' | Driver App" />
<meta property="og:url" content="'.$actual_link.'" />
<meta property="og:image" content="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo.png" />
<meta property="og:description" content="We are seeking drivers who can transport laundry between near by users and laundromats." /> 
<meta property="og:site_name" content="Drive '.$contactinf['Name'].'" />';
		
	

	
		
		?>
	
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
    _paq.push(['setSiteId', '5']);
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
					<header id="header" class="alt">
						<h1><a href="about-driver.php"><?php echo $contactinf['Name']; ?> Driver</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="<?php echo "https://".$contactinf['Website'] ?>"><?php echo $contactinf['Name']; ?> Home</a></li>
											<li><a href="#app">Download Drive's App</a></li>
											<li><a href="about-driver">About Driver</a></li>
										<li ><a href="faq">FAQ</a></li>
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
			
			echo'	<section id="banner" style="background-image: url(images/Birmingham_Skyline.jpeg); background-repeat: no-repeat;
    background-size: auto 100%;">';
			
			}else{
			
			echo'		<section id="banner" style="background-image: url(images/Birmingham_Skyline.jpeg); background-repeat: no-repeat;
    background-size: 100% auto;">';
    
    }
    
    
    
    
    if(isset($_SESSION['errormessage'])){
        
        echo'<h3>'.$_SESSION['errormessage'].'</h3>';
        unset($_SESSION['errormessage']);
    }
    
    
    ?>
					    
					    					
						<div class="inner">
						    
						    <img src="../images/app-logo-transparent.png" style="width:100px;" alt="" />
							<h2>Drive for <?php echo $contactinf['Name']; ?></h2>
						<p>Download the <?php echo $contactinf['Name']; ?> Driver's App</p>
							<ul class="actions special" id="app">
<!--<li><a href="#" target="_blank" ><img src="../images/playstore1.png" ></a></li>-->
<li><a href="https://itunes.apple.com/gb/app/drive-delivrmat/id1426759237?mt=8" target="_blank" ><img src="../images/appstore1.png" style="width:200px;"></a></li>
							</ul>
						</div>
						<a href="#one" class="more scrolly">Learn More</a>
					</section>

				<!-- One -->
					<section id="one" class="wrapper style1 special" >
						<div class="inner" >
							<header class="major">
								<h2>Become a <?php echo $contactinf['Name']; ?> driver!</h2>
								<p><?php echo $contactinf['Name']; ?> is looking for passionate individuals to join our team. We are seeking drivers who can transport laundry between users and nearby laundromats. </p>
							</header>
							<ul class="icons major">
								<li><span class="icon fa-diamond major style1"><span class="label">Lorem</span></span></li>
								<li><span class="icon fa-heart-o major style2"><span class="label">Ipsum</span></span></li>
								<li><span class="icon fa-code major style3"><span class="label">Dolor</span></span></li>
							</ul>
						</div>
					</section>

				<!-- Two -->
					<section id="two" class="wrapper alt style2">
					<?php echo'	<section class="spotlight">
							<div class="image"><img src="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo-transparent.png" style="width:100px; height:auto; margin-right:auto; margin-left:auto;" alt="" /></div><div class="content">
								<h2>1.) Create a '.$contactinf['Name'].' Driver Account</h2>
								<p>Create a '.$contactinf['Name'].' Drivers account and begin the application process. '.$contactinf['Name'].' requires that you have a <a href="https://stripe.com/" target="_blank" style="font-weight:bold;">Stripe Payment account</a> to safely transfer earned funds to your bank account.</p>
							</div>
						</section>
						<section class="spotlight">
							<div class="image"><img src="https://'.$_SERVER['HTTP_HOST'].'/images/laundry-day-630x355.jpg" alt="" /></div><div class="content">
								<h2>2.) Undergo Background Check</h2>
								<p>The safety of our user\'s laundry is our top priority. '.$contactinf['Name'].' requires that you undergo a background check before becoming a driver.</p>
							</div>
						</section>
						<section class="spotlight">
							<div class="image"><img src="https://'.$_SERVER['HTTP_HOST'].'/images/19404081.jpg" alt="" /></div><div class="content">
								<h2>3.) Start picking up and droppping off laundry today!</h2>
								<p>Start accepting '.$contactinf['Name'].' trips and earn money today!</p>
							</div>
						</section>'; ?>
					</section>

				<!-- Three -->
					<section id="three" class="wrapper style3 special">
						<div class="inner">
							<header class="major">
								<h2>Benefits of becoming a  Driver </h2>
								<p>"<?php echo $contactinf['Name']; ?> connects users to nearby laundromats. Doing laundry is time consuming
and may not fit in your busy schedule. <?php echo $contactinf['Name']; ?>'s mission is to save you time in your day by picking up your dirty laundry
at your door and delivering it to you when it's done. "</p>
							</header>
							<ul class="features">
								<li class="icon fa-paper-plane-o">
									<h3>Make Your Own Hours</h3>
									<p><?php echo $contactinf['Name']; ?> allows you to make your own hours. Earn some extra cash whenever your busy schedule allows you to.</p>
								</li>
								<li class="icon fa-laptop">
									<h3>Be Your Own Boss</h3>
									<p>Become your own boss. <?php echo $contactinf['Name']; ?> allows you to accept as many trips as you like. Start earning money today!</p>
								</li>
								<li class="icon fa-code">
									<h3>Make Extra Money With Spare Time</h3>
									<p>Do you have a job already? <?php echo $contactinf['Name']; ?> is the perfect way to put some extra cash in your pocket.</p>
								</li>
								<li class="icon fa-headphones">
									<h3>Transfer your funds at anytime!</h3>
									<p><?php echo $contactinf['Name']; ?> allows you to transfer your <?php echo $contactinf['Name']; ?> funds to your <a href="https://stripe.com/" target="_blank" style="font-weight:bold;">Stripe Payments account</a> anytime.</p>
								</li>
								<li class="icon fa-heart-o">
									<h3>Get paid for duration of trip</h3>
									<p>You get paid for each minute of your trip. The duration of the trip is one of the main factors when determining how much a driver is paid.</p>
								</li>
								<li class="icon fa-flag-o">
									<h3>Get paid for each mile you drive</h3>
									<p>Select longer trips to earn more money. The distance of the trip is the most important factor when determining how much a driver is paid.</p>
								</li>
							</ul>
						</div>
					</section>

		

				<!-- Footer -->
					<footer id="footer">
						<ul class="icons">
						<?php 
						
					
						echo'
						<h2>Download '.$contactinf['Name'].' Driver\'s App!</h2>
						<ul class="actions special">
<!--<li><a href="#" target="_blank"><img src="../images/playstore1.png" ></a></li>-->
<li><a href="https://itunes.apple.com/gb/app/drive-delivrmat/id1426759237?mt=8"  target="_blank"><img src="../images/appstore1.png" style="width:200px;"></a></li>
							</ul>';
						
						
							echo'<li><a href="'.$twitter.'" class="icon fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
							<li><a href="'.$facebook.'" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
							<li><a href="'.$instagram.'" class="icon fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>
						
							<li><a href="mailto:contactus@'.$_SERVER['HTTP_HOST'].'" class="icon fa-envelope-o"><span class="label">Email</span></a></li>';
							
							?>
						</ul>
						<?php echo'<ul class="copyright">
							<li><a href="http://icitechnologies.com" target="_blank">&copy; ICI Technologies LLC</a></li>
							<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-terms-conditions.php">Terms</a></li>
						</ul>'; ?>
					</footer>

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
<?php COUCH::invoke(); ?>