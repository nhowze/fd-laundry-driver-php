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







$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_POST['ordernum']."' ";

$result = mysqli_query($mysqli, $sql);

$ordergroup = mysqli_fetch_assoc($result);







$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";

$confirm= mysqli_query($mysqli, $sql);

$confirm= mysqli_fetch_assoc($confirm);







if($confirm['Address'] == "" || $confirm['City'] == "" || $confirm['State'] == "" || $confirm['Zip'] == ""){

	

	

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

			<a  style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:2%;">Monthly Bonus</h3></a>

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





			

			echo'	<section  style="height:auto; " >

				<div class="inner" style="padding:5%; padding-top:15%;  height:auto; min-height:450px; text-align:center;">';

			

			

			echo'<img src="https://'.$_SERVER['SERVER_NAME'].'/images/app-logo-transparent.png" style="width:25%; height:auto;" alt="" />';

			



			echo'<h2>'.date("F Y").'</h2>';

    

			$sql2 ="SELECT * FROM Trip_Goals   ORDER BY Trips_Completed";

			$result2 = mysqli_query($mysqli, $sql2);

			

	

				

				

				echo'<table>

<tr>

<th style="text-align:center;">Trips Completed</th>

<th style="text-align:center;">Goal</th>

<th style="text-align:center;">Reward</th></tr>

';

				

				//begin calculate total monthly payments

				$todatdate = date("Y-m-d");

				

				//monthly pickup sum

				$sql2 ="SELECT Count(*) AS TotalPickupAmount FROM OrderGroup  WHERE `DriverPickup_ID` = ".$confirm['id']." AND MONTH(`Date`) = MONTH('".$todatdate."') AND (`Status` ='Received' OR `Status` = 'In Progress' OR `Laundry_Complete` = 1  ) ";



				$pickupt = mysqli_query($mysqli, $sql2);

				$pickupt= mysqli_fetch_array($pickupt);

				$pickupt = $pickupt['TotalPickupAmount'];

				

				

				//monthly delivery sum

				

				$sql2 ="SELECT Count(*) AS TotalPickupAmount FROM OrderGroup  WHERE `DriverDeliver_ID` = ".$confirm['id']." AND MONTH(`Date`) = MONTH('".$todatdate."') AND `Status` ='Order Complete'  ";

				

				$deliveryt = mysqli_query($mysqli, $sql2);

				$deliveryt= mysqli_fetch_array($deliveryt);

				$deliveryt= $deliveryt['TotalPickupAmount'];

				

				

				$total = $pickupt + $deliveryt;

				

				//end total payment

				

				while($row2 = $result2->fetch_assoc()) {

    

					

					if($total >= $row2['Trips_Completed']){

						

						

						echo'<tr style="background:green;">';

						

					}else{

						

						echo'<tr>';

					}

					

					

    echo'

<td style="text-align:center;">'.$total.'</td>

<td style="text-align:center;">'.$row2['Trips_Completed'].'</td>

<td style="text-align:center;">$'.$row2['Reward'].'</td>

</tr>';

    

    }



echo'</table>';

    



?>



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