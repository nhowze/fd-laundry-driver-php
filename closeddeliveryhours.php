<?php

include("LoginSystem-CodeCanyon/cooks.php");

//session_start();

include('LoginSystem-CodeCanyon/db.php');

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



$sqldel = "SELECT * FROM Delivery_Hours WHERE ID = 1 ";





$deliveryhours = mysqli_query($mysqli, $sqldel);

$deliveryhours= mysqli_fetch_assoc($deliveryhours);



if($confirm['Address'] == "" || $confirm['City'] == "" || $confirm['State'] == "" || $confirm['Zip'] == ""){

	

	

	echo'<script>

						window.location.href = "setuphomeaddress.php";

			</script>';

	

}





if($confirm['Phone_Confirmed'] == "False" ||  $confirm['StripeAccount'] == ""){

	

	

	echo'<script>

						window.location.href = "setupaccount.php";

			</script>';

	

}





if($confirm['Checkr_Status'] != "Approved" || $confirm['DOB'] == '0000-00-00'){

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

	    

		<title><?php echo $contactinf['Name']; ?> | Recent Trips</title>

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

			<a href="recent" style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:12px;">Delivery Hours Closed</h3></a>

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



			

			echo'	<section  style=" height:auto; ">

				<div class="inner" style="padding:5%; padding-top:20%;  height:auto; min-height:450px; text-align:center;">';

			

		

    

   

    echo'

    

   

    <div style="margin-top:10%; text-align:center;">

  <img src="images/applogo.png" style="width:30%; "><br><br>

    <h3> Delivery Hours will resume in:</h3> 

    <h2 id="demo"></h2>

    

    </div>









';



					echo'	</div>

					</section>



		





					<!-- Footer -->

				<footer id="footer">

						<ul class="icons">

								<li><a href="'.$twitter.'" class="icon fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>

							<li><a href="'.$facebook.'" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>

							<li><a href="'.$instagram.'" class="icon fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>

						

							<li><a href="mailto:'.$contactinf['Email'].'" class="icon fa-envelope-o"><span class="label">Email</span></a></li>

						</ul>

						<ul class="copyright">

							<li><a href="http://icitechnologies.com" target="_blank">&copy; ICI Technologies LLC</a></li>

						</ul>

					</footer>';

					

					

					

					?>

			</div>



<script>

// Set the date we're counting down to



<?php 



if($datenum == 0 || $datenum == 6){



		$offsetd = $deliveryhours['Weekend_Open'];

		

}else{

	

	$offsetd = $deliveryhours['Week_Open'];

}





//

if(date("H:i:s") <= "23:59:59" && date("H:i:s") >= '.$offsetd.'){					//midnight check

$datenum = date("w");



$datenum = +1;



$opendate= date("M j, Y", strtotime("+ 1 day"));





}else{

	

	$datenum = date("w");

	$opendate= date("M j, Y");

	

}









if($datenum == 0 || $datenum == 6 || $datenum == 7){	//weekend

	

	echo'var countDownDate = new Date("'.$opendate.' '.$deliveryhours['Weekend_Open'].'").getTime();';

	

}else{



	echo'var countDownDate = new Date("'.$opendate.' '.$deliveryhours['Week_Open'].'").getTime();';





}



?>





// Update the count down every 1 second

var x = setInterval(function() {



  // Get todays date and time

  var now = new Date().getTime();



  // Find the distance between now and the count down date

  var distance = countDownDate - now;



  // Time calculations for days, hours, minutes and seconds

  var days = Math.floor(distance / (1000 * 60 * 60 * 24));

  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

  var seconds = Math.floor((distance % (1000 * 60)) / 1000);



  // Display the result in the element with id="demo"

  

  

if(hours != 0){

	  document.getElementById("demo").innerHTML =  hours + "h "

  + minutes + "m " + seconds + "s ";

}else{



	  document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";

	

}

  // If the count down is finished, write some text 

  if (distance < 0) {

    clearInterval(x);

    document.getElementById("demo").innerHTML = "EXPIRED";

  }

}, 1000);

</script>

<?php 





//echo($opendate);



?>



<div id="ajaxDiv"> 



</div>

	<script>

function updateHours() {

  setInterval(function(){ 

	

	  $("#ajaxDiv").load("Backend/checkifopenddeliveryhours.php");



	  }, 5000);

}





updateHours()

	







</script>















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