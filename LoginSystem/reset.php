<?php 

include_once("cooks.php");

//session_start(); 

unset($_SESSION['errormessage']);


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

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

?>
<!DOCTYPE html>
<head>
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
   
    	<link rel="icon" 
      type="image/jpg" 
      href="../../images/app-logo.png">
	    
		<title><?php echo $contactinf['Name']; ?> | User Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
    
    	<script>
		function validateForm() {

                        var password1 = document.getElementById("password1").value;
			var password2 = document.getElementById("password2").value;




if(password1 != password2){

alert("Passwords don't match");
return false;
}


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
 <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
		<!-- Header -->
	
				<header id="header" class="alt">
					
					<h1 id="logo"><a href="redirectmain.php"><?php echo $contactinf['Name']; ?></a></h1>
				
			
					<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
												<li><a href="redirectmain.php" >Home</a></li>
									
										</ul>
									</div>
								</li>
							</ul>
						</nav>
			
					</header>
				
	

		<!-- Wrapper -->
			<div id="wrapper" >

			

						<!-- One -->
							<section id="one" ><br><br>
							
								<div class="container" style="padding-left:10%;">
									<header class="major">
									    
									    
									  
										<h2>Reset Password</h2>
		
</header>
										
	
	
	<form class="form-horizontal" name="myForm" id="reset_pwd" method="post" style="width:100%;" action="process_reset.php" onsubmit="return validateForm()" enctype="multipart/form-data">
         

        <div>Make sure both passwords match.</div>
	<?php
	include_once("db.php");
$con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
or die ("Could not connect to mysql because ".mysqli_error());

mysqli_select_db($con,$db_name)  //select the database
or die ("Could not select to mysql because ".mysqli_error());

	$key=mysqli_real_escape_string($con,$_GET["k"]);
	if (!empty($key))
{
	

	//query database to check activation code
	$query="select * from ".$table_name." where activ_key='$key' and activ_status='2'";
	$result=mysqli_query($con,$query) or die('error');

		 if (mysqli_num_rows($result))
		 {
			 $row=mysqli_fetch_array($result);
			 if ($row['activ_status']=='2')
			 {
			 $username=trim($row['username']);
			 $_SESSION['username'] = $username;
			 //html
			 ?>
			 
		 
		
        <div class="control-group" style="width:100% !important;">
            <input type="password" id="password1" name="password1" placeholder="Password" style="width:80%;">
        </div><br>
        <div class="control-group" style="width:100% !important;">
            <input type="password" id="password2" name="password2" placeholder="Retype Password" style="width:80%;">
        </div>	
<br>
        <button
        type="submit" class="btn btn-lg btn-primary btn-sign-in" data-loading-text="Loading...">Reset</button>
		
            <div class="messagebox">
                <div id="alert-message"></div>
            </div>
   
		<?php
			}
			 else
			 {
				echo "<div class=\"messagebox\"><div id=\"alert-message\">You can login</div></div>"; 
			 }
			 
		 }
		 else
		 {
			 echo "<div class=\"messagebox\"><div id=\"alert-message\">You can login</div></div>";
			 //header('Location: $url');
		 }
}
else
	echo "<div class=\"messagebox\"><div id=\"alert-message\">error</div></div>";
	
	?>
    
	 </form>
    
	
	
										
								</div>
							</section>

					

					

					

					

					</div>

				<!-- Footer -->
					<section id="footer">
						<div class="container">
						    
						    
						    				<ul class="icons">
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
					</section>

			</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.scrollex.min.js"></script>
			<script src="../assets/js/jquery.scrolly.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>
