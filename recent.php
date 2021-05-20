<?php
include_once("LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('LoginSystem-CodeCanyon/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


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
	
}else if($confirm['Phone_Confirmed'] == "False" ||  $confirm['StripeAccount'] == ""){
	
	
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
			<div id="page-wrapper">

				<!-- Header -->
				<header id="header" class="alt" style="position:fixed; background:#2e3842;">
			<a href="recent" style="text-decoration: hidden !important;"><h3 style="text-align:center; padding-top:12px;">Recent Trips</h3></a>
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
			    
			    tr, table{
			    
			    background:rgba(0,0,0,0) !important;
			    border:none !important;
			    
			    
			    }

			</style>
				<!-- Three -->
					    		<?php

			
			echo'	<section  style=" height:auto; background: #2e3842;">
				<div class="inner" style="padding:5%;  padding-top:0;  height:auto; background: #2e3842;">';
			
		
			
			
			//start report div
			
			$mindate = date("Y-m-d", strtotime("-1 days"));
			$maxdate = date("Y-m-d");
			
			
			if(isset($_SESSION['report'])){
				
				
				if($_SESSION['report'] == "There was an error sending your report. Please try again."){
					echo'<h4 style="color: red;">'.$_SESSION['report'].'</h4>';
				}else{
					
					echo'<h4 style="color:green;">'.$_SESSION['report'].'</h4>';
				}
				
				
				unset($_SESSION['report']);
			}
			
			
			echo'<ul class="actions"><li><div style=" border-bottom:solid; background: #2e3842;  ">
<br><br>';

			if(isset($_SESSION['report'])){
				
				
				if($_SESSION['report'] == "There was an error sending your report. Please try again."){
					echo'<h4 style="color: red;">'.$_SESSION['report'].'</h4>';
				}else{
					
					echo'<h4 style="color:green;">'.$_SESSION['report'].'</h4>';
				}
				
				
				unset($_SESSION['report']);
			}
			
			
echo'<form method="get" action="Backend/sendreport.php" onsubmit="validateF()" enctype="multipart/form-data">
<input type="hidden" value="'.$row['id'].'" name="drivrID">
<input type="hidden" value="trips" name="report">
		
<table style="width:100% !important; table-layout:fixed;">
		
<tr style="border:none;">
		
<td style="width:50%;">Min Date: <input type="date" name="mindate" id="mindate"  value="'.$mindate.'"" style="font-size:80%; display: inline-block; color:black;" required></td>
<td style="width:50%;">Max Date: <input type="date" name="maxdate" id="maxdate" value="'.$maxdate.'" style="font-size:80%; display: inline-block; color:black;"   required> </td>
</tr>
<tr style="background:rgba(0,0,0,0); border:none;">
<td style="width:100%;" colspan="2"><input type="submit" style="font-size:90%;"  value="Request  Report"></td>
		
</tr></table>
		
</form>
</div></li>
';
			
			//end report div
			
			
			
    
    
			$sql2 ="SELECT * FROM OrderGroup WHERE (DriverPickup_ID = ".$confirm['id']." AND Status <> 'Driver In Transit' AND Status <> 'Driver In Transit With Laundry') 
OR (DriverDeliver_ID = ".$confirm['id']." AND Status = 'Order Complete') ORDER BY Date, Delivery_Time, Pickup_Time ";
    $result2 = mysqli_query($mysqli, $sql2);
    
    
    if ($result2->num_rows > 0) {
    
    $count = 1;
    echo'<li><table style="margin-top:10%;">';
    
    
    while($row2 = $result2->fetch_assoc()) {
    	
    	
    	$sql = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
    	$result = mysqli_query($mysqli, $sql);
    	$userinfo = mysqli_fetch_assoc($result);
    	
    	
    	if($row2['DriverPickup_Username'] == $_SESSION['username']){
    		
    		$pick=	$count.". ".$userinfo['First_Name']." &#8680; ".$row2['Name']."<br>";
    	$pdist = $row2['PickupMiles'];
    	$pfee = $row2['PickupFee'];
    		
    	
    	
    	$count++;
    	}
    	
    	
    	if($row2['DriverDeliver_Username'] == $_SESSION['username']){
    		
    		$deliv = $count.". ".$row2['Name']." &#8680; ".$userinfo['First_Name']."<br>";
    		$ddist = $row2['DeliverMiles'];
    		$dfee = $row2['DeliverFee'];
    		
    		
    		$count++;
    	}
    	
    	
    	


	
	
	
	if($row2['DriverPickup_Username'] == $_SESSION['username']){
		
		echo'
								
<tr style="cursor:pointer;" onclick="submitCurrentForm(this); border-bottom:solid !important;">
<form class="submitp"  method="post" action="finaltransfer.php">
<input type="hidden" name="track" value="0">
<input type="hidden" name="oid" value="'.$row2['ID'].'">
		
		
<td style="text-align:center;">';
		
	echo($pick);
	$pickuptime = date("m-d-Y g:i A", strtotime($row2['Initial_Pickup_Start']));
$delivertime=date("m-d-Y g:i A", strtotime($row2['Initial_Delivery_Start']));
	
	echo''.$pickuptime.'<br>';
	
	$fee = $pfee;
	$miles = $pdist;
	
	
	
	$fee = number_format($fee,2);
	
	echo'
			
			
<table style="background:rgba(0,0,0,0); padding:0; margin:0;">

<tr style="border:none; background:rgba(0,0,0,0); border-bottom:solid !important;">
<td style="text-align:center;">Distance: '.$miles.' mi</td>
<td style="text-align:center;">Trip Total: $'.$fee.'</td>
</tr>
</table>
					
					
';
	echo'</td>
				
				
				
</form>
</tr>';
	
	
	
	
}


if($row2['DriverDeliver_Username'] == $_SESSION['username']){
	
	echo'
		 		
<tr style="cursor:pointer;" onclick="submitCurrentForm(this); border-bottom:solid !important;">
<form class="submitp"  method="post" action="finaltransfer.php">
<input type="hidden" name="track" value="1">
<input type="hidden" name="oid" value="'.$row2['ID'].'">
				
				
<td style="text-align:center;">';
	
	echo($deliv);
	$pickuptime = date("m-d-Y g:i A", strtotime($row2['Initial_Pickup_Start']));
$delivertime=date("m-d-Y g:i A", strtotime($row2['Initial_Delivery_Start']));

echo''.$delivertime.'<br>';


	$fee = $dfee;
	$miles = $ddist;
	
	$fee = number_format($fee,2);
	
	echo'
       		
       		
<table style="background:rgba(0,0,0,0); padding:0; margin:0;">
<tr style="border:none; background:rgba(0,0,0,0); border-bottom:solid !important;">
<td style="text-align:center;">Distance: '.$miles.' mi</td>
<td style="text-align:center;">Trip Total: $'.$fee.'</td>
</tr>
</table>
			
			
';
	echo'</td>
			
			
			
</form>
</tr>';

}




    	
    	
    }
    
    
    
    echo'</table></li>';
 }else{
    	
    	
    	echo'<li><p>You have not completed any trips yet.</p></li>';
    	
    }
    
   
    ?>
    
    </ul>
    

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

<script>
function validateF(){
	
	var min = document.getElementById("mindate").value;
	var max = document.getElementById("maxdate").value;
	
	if(max < min){
		event.preventDefault();
		alert("Invalid Date Range");
		return false;
		
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