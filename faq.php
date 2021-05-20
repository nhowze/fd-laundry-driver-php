<?php require_once('../couch/cms.php');
include_once("../Users/LoginSystem-CodeCanyon/cooks.php");
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
	  <cms:template title='Driver FAQ' order='10'>

</cms:template>
		<title><?php echo $contactinf['Name']; ?> | Driver Frequently Asked Questions</title>
		
		
			<?php 	
		
		echo'
<meta name="description" content="We are seeking drivers who can transport laundry between near by users and laundromats.">
<meta name="application-name" content="'.$contactinf['Name'].'">
<meta name="author" content="ICI Technologies LLC">

 <meta name="keywords" content="'.$contactinf['Name'].' driver faq,'.$contactinf['Name'].' driver frequently asked questions,drive '.$contactinf['Name'].','.$contactinf['Name'].' driver,become a '.$contactinf['Name'].' driver,register drive '.$contactinf['Name'].',drive for '.$contactinf['Name'].',work for '.$contactinf['Name'].','.$contactinf['Name'].',laundry app,laundry delivery app,laundry delivery,deliver laundry,laundry delivery service,delivery my laundry,laundry service,laundry pickup,pickup my laundry,
laundromat delivery service,laundromat app,laundromat pickup">';  


		$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


echo'<!-- Twitter Card data -->
<meta name="twitter:title" content="'.$contactinf['Name'].' | Driver" >
<meta name="twitter:card" content="summary" >
<meta name="twitter:site" content="@publisher_handle" >
<meta name="twitter:description" content="We are seeking drivers who can transport laundry between near by users and laundromats." >
<meta name="twitter:creator" content="@author_handle" >
<meta name="twitter:image" content="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo.png" >



<!-- Open Graph data -->
<meta property="og:title" content="'.$contactinf['Name'].' | Driver" />
<meta property="og:url" content="'.$actual_link.'" />
<meta property="og:image" content="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo.png" />
<meta property="og:description" content="We are seeking drivers who can transport laundry between near by users and laundromats." /> 
<meta property="og:site_name" content="'.$contactinf['Name'].' Driver" />';
		
	

	
		
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
											<li><a href="about-driver#app">Download Drive's App</a></li>
											<li><a href="about-driver">About Driver</a></li>
										<li ><a href="faq">FAQ</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>



				<!-- One -->
					<section id="one" class="wrapper style1 special" >
						<div class="inner" >
							<header class="major">
								<h2>Frequently Asked Questions</h2>
							
							</header>
							
							<?php
						
								require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

if($detect->isMobile()) {
    
     echo'<ul style="text-align:left;">';
    
}else{
    
    
    echo'<ul class="actions" >';
    
    
}
	?>						
							
								<li><a href="#1">How long does it take for funds to transfer to my stripe account?</a></li>
									<li><a href="#2">How long does it take for funds to transfer from my stripe account to my bank account?</a></li>
							</ul>
							
						</div>
					</section>

				<!-- Two -->
					<section id="two" class="wrapper alt style2">
						<section class="spotlight" id="1">
							<div class="image"><img src="images/stripe.png" style="width:100%; height:auto; margin-right:auto; margin-left:auto;" alt="" /></div><div class="content">
								<h2>How long does it take for funds to transfer to my stripe account?</h2>
								
								<p>
							    Typically it takes 2 days for earned funds to become available in your Stripe Payment account. 
							</p>
							<h4>All Stripe accounts can have balances in two states:</h4>
							<ul>
							    <li><strong>pending</strong>, meaning the funds are not yet available to pay out</li>
							     <li><strong>available</strong>, meaning the funds can be paid out now</li>
							    
							</ul>
							
							<p>
							    The charged amount, less any Stripe fees, is initially reflected on the pending balance, and becomes available on a 2-day rolling basis. (This timing can vary by country and account.) Available funds can be paid out to a bank account or debit card. Payouts reduce the Stripe account balance accordingly.
							</p>
								
							</div>
						</section>
						<section class="spotlight" id="2">
							<div class="image"><img src="images/banktransfer2.jpg" style="width:100%;" alt="" /></div><div class="content">
								<h2>How long does it take for funds to transfer from my stripe account to my bank account?</h2>
									    <p>
			        To receive funds for payments you’ve processed, Stripe makes deposits (payouts) from your available account balance into your bank account. This account balance is comprised of different types of transactions (e.g., payments, refunds, etc.).
			        
			    </p>
			    
			    <p>
			        Payout availability depends on a number of factors such as the industry and country you’re operating in, and the risks involved. When you start processing live payments from your customers with Stripe, you will not receive your first payout until 7–10 days after your first successful payment is received. The first payout usually takes a little longer in order to establish the Stripe account. Subsequent payouts are then processed according to your account’s <a href="https://stripe.com/docs/payouts#payout-schedule" target="_blank" style="text-decoration:underline;">payout schedule</a>.
			        
			    </p>
			    
			    
			    <p>
			        You can view a list of all of your payouts and the date that they are expected to be received in your bank account in the <a target="_blank" href="https://dashboard.stripe.com/payouts" style="text-decoration:underline;">Dashboard</a>.
			        
			    </p>
							</div>
						</section>
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
						
							<li><a href="mailto:'.$contactinf['Email'].'" class="icon fa-envelope-o"><span class="label">Email</span></a></li>';
							
							?>
						</ul>
						<?php echo'<ul class="copyright">
						<li><a href="http://icitechnologies.com" target="_blank">&copy;
ICI Technologies LLC All rights reserved.</a></li>

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