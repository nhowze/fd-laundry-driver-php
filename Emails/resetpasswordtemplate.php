<?php 	
	
include_once("../LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('../LoginSystem-CodeCanyon/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';



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


$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Delivrmat' ";
$result = mysqli_query($mysqli, $sql);
$plugin = mysqli_fetch_assoc($result);
echo($plugin['HTML']);




if($row["Profile_Pic"] != ""){
	$profilepic = $row["Profile_Pic"];
}else{
	$profilepic ="images/avatar.jpg";
}




$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);




?>
<html>
	<head>
		<link rel="icon" 
      type="image/jpg" 
      href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/images/app-logo.png">
	    
		<title><?php echo $contactinf['Name']; ?>| Reset Password</title>
		
		
	
		
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Users/assets/css/main.css" />
			<style>
		    
		    input[type="submit"],
	input[type="reset"],
	input[type="button"],
	.button {
	    padding-left:10px !important; 
	    padding-right:10px !important;
	    
	    
	    
	    
	}
	
		  td{
	    font-size:90%;
	    
	    }  
	    
	    table{
	    
	    width:100% !important;
	    
	    }
	    
		</style>
	
		
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript" src="http://usmntcenter.com/js/jquery-ui-1.8.21.custom.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	
	<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

	
	
			<style>
/* The container */
.container2 {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
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
</style>



<link rel="stylesheet" href="https://rawgit.com/anhr/InputKeyFilter/master/InputKeyFilter.css" type="text/css">		
	<script type="text/javascript" src="https://rawgit.com/anhr/InputKeyFilter/master/Common.js"></script>
	<script type="text/javascript" src="https://rawgit.com/anhr/InputKeyFilter/master/InputKeyFilter.js"></script>




  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
    
    
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
   Stripe.setPublishableKey("<?php echo $keys['Key']; ?>");
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form").attr('action', 'updatepaymentnew.php');
                    
                    
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }
            $(document).ready(function() {
                $("#payment-form").submit(function(event) {
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
                });
            });
        </script>
    
    
    
    
<style>

 div.w2ui-time{
 
 color:black;
 
 }
</style>
	<script src="laundry/moment.js"></script>

	
	
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
	<body class="is-preload">



	<!-- Wrapper -->
		

						<!-- One -->
							<section id="one" style="width:100%; margin:auto; padding:auto; text-align:left; top:">
							
								<div class="container" style="margin:auto; padding:auto; text-align:center; width:100%;">





<style>

table, th, td, tr{

text-align:center !important;
padding:0 !important;
font-size:12px;



}



ul, li{

list-style-type: none;
display:inline !important;
}

</style>

<?php

$odate = date('m/d/Y',strtotime($ordersummary['Date']));



echo'<div style="text-align:center;"><img src="https://'.$_SERVER['HTTP_HOST'].'/Users/images/delivrmatlogo3.png">

<h2>Reset Password</h2>
<p>'.$_GET['message'].'</p>

';



?>

<!-- One -->

<br><br>
<header class="special container">
						
				
						
					

	
	
<video style="width:100%; margin-top:5%; margin-bottom:10%;" controls>
  <source src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/delivrmat.mp4" type="video/mp4">

</video>



<p>"<strong><?php echo $contactinf['Name']; ?></strong> connects users to laundromats near them. Doing laundry is time consuming and may not fit in your busy schedule. <strong><?php echo $contactinf['Name']; ?>'s</strong> mission is to save you time in your day by picking up your dirty laundry at your door and delivering it to you when it's done.
						"</p>

						
					
					</header>



						<section id="sec2" class="wrapper style2 container special-alt">
							
								
			
								
							</div>
						</section>
<br><br>


<section class="wrapper style1 container special">
							<ul class="actions"></ul>
								<li>

									<section>
										<span class="icon featured fa-check" style="font-size:100px;"></span>
										<header>
											<h3>Don't know how to do your laundry?</h3>
										</header>
										<p>It's ok if you don't know how to do your laundry, that's why we are here! We will pickup, wash, and deliver your laundry back to you in a timely manner.
									</section>

								</li>
								<li>

									<section>
										<span class="icon featured fa-check" style="font-size:100px;"></span>
										<header>
											<h3>Don't have the time to do your laundry?</h3>
										</header>
										<p>We know that you may have a busy schedule which prevents you from doing your laundry. <strong><?php echo $contactinf['Name']; ?></strong> is the perfect solution to this problem!
									</section>

								</li>
								<li>

									<section>
										<span class="icon featured fa-check" style="font-size:100px;"></span>
										<header>
											<h3>Too Lazy?</h3>
										</header>
										<p>Everyone gets lazy from time to time and laundry can be an unappealing task to start. Thats why <strong><?php echo $contactinf['Name']; ?></strong> is perfect for you! We will pickup, wash and deliver back your laundry all with a click of a button.</p>
									</section>

								</li>
								</ul>
							
					



							<header class="major">
								<h2><strong>Become a</strong> <?php echo $contactinf['Name']; ?><strong> driver!</strong></h2>
							</header>
							
			
								    
								  <ul class="actions">
								<li>

									<section>
										<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/images/19404081.jpg" style="width:100%;" alt="" />
										<header>
											<h3>Become a <strong><?php echo $contactinf['Name']; ?></strong> driver!</h3>
										</header>
										<p><?php echo $contactinf['Name']; ?> is looking for passionate individuals to join our team. We are seeking drivers who can transport laundry between near by users and laundromats.</p>
										
										<a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Drivers/about-driver.php" class="button primary">Become a Driver!</a><br><br>
									</section>

								</li>
								<li>

									<section>
										<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/images/laundry-day-630x355.jpg" style="width:100%;" alt="" />
										<header>
											<h3>Contact Us: </h3> 
										</header>
										<ul style="list-style-type: none;">
										    <li>Email: <a href="mailto:contactus@icitechnologies.com">contactus@icitechnologies.com</a></li><br><br><br>
										   
										    
										</ul>
									</section>

								</li>
								</ul>
							
							
							
						</section>



</div>




						</div>

													</section>



					<!-- CTA -->
				<section id="cta" style="background: #4acaa8 !important; padding:5%; background-color: #4acaa8 !important; text-align:center !important;">
				

					<footer>
						
			
				
						<div style="text-align:center !important;">
										<img style="width:100px;" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/images/app-logo-transparent.png"  alt="" />
				
<h3 style="color:white;"><?php echo $contactinf['Name']; ?> App</h3>
						
		   <a href="https://play.google.com/store/apps/details?id=com.brommko.android.delivrmat" target="_blank"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Users/images/playstore2.png" ></a>
<a href="https://itunes.apple.com/gb/app/delivrmat/id1426772119?mt=8" target="_blank"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Users/images/appstore2.png" ></a><br><br>
						</div>
						
					</footer>

				</section>
					

					

				<!-- Footer -->
					<section id="footer" style=" width:100%; text-align:center !important;">
						<div class="container" style="text-align:center !important;">
						
						   <?php
				    
					echo'<ul class="icons">
<li><a  target="_blank" href="https://'.$_SERVER['HTTP_HOST'].'/Drivers/about-driver.php" >Become A Driver</a></li>
						<li><a href="'.$twitter.'" target="_blank"  class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="'.$facebook.'" target="_blank"  class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="'.$instagram.'" target="_blank"  class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							
					</ul>';
					
					?>
						<br><br>
						
							<ul class="copyright">
								<li><a href="http://icitechnologies.com" target="_blank" style="" target="_blank">&copy;
ICI Technologies LLC All rights reserved.</a></li>
<li><a style="" target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a style="" target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/legal/delivrmat-terms-conditions.php">Terms</a></li>
							</ul>
						</div>
					</section>

			</div>








		<!-- Scripts -->
			

	</body>
</html>