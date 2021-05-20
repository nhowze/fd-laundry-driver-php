<?php

include_once '../../includes/db_connect.php';
include_once '../../includes/functions.php';

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

?>
	
	
	<!DOCTYPE html>
<head>
    <link rel="icon" 
      type="image/jpg" 
      href="../images/app-logo.png">
	    
		<title><?php echo $contactinf['Name']; ?> | Activation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	    <link href="css/style.css" rel="stylesheet" media="screen">
</head>

<body>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <div class="logo">
         <h2><?php include_once('db.php'); ?></h2>

    </div>
    <form class="form-horizontal" id="login_form">
         <h2>User Activation</h2>

        <div class="line"></div>
        

  
       




<?php
	include_once("db.php");
	 $con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
	or die ("Could not connect to mysql because ".mysqli_error());

$key=mysqli_real_escape_string($con,$_GET["k"]);

if (!empty($key))
{
	

	mysqli_select_db($con,$db_name)  //select the database
	or die ("Could not select to mysql because ".mysqli_error());

	//query database to check activation code
	$query="select * from ".$table_name." where activ_key='$key'";
	$result=mysqli_query($con,$query) or die('error');
		 if (mysqli_num_rows($result))
		 {
			 $row=mysqli_fetch_array($result);
			 if ($row['activ_status']!='1')
			 {
			 $query="update ".$table_name."	 set activ_status='1' where activ_key='$key'";
			 $result=mysqli_query($con,$query) or die('error');
			
			 echo "<p>User Account activated successfully.<a href='$url/../login.php'>";
			 echo "Login to continue</a></p>";
			 }
			 else
			 {
				 echo "Account already activated";
				 //header('Location: $url');
			
				
			 }
			 
		 }
		 else
		 {
			 echo "<div class=\"messagebox\"><div id=\"alert-message\">Invalid Activation Key</div></div>";
			 //header('Location: $url');
		 }
}
else
	echo "<div class=\"messagebox\"><div id=\"alert-message\">error</div></div>";
	
?>

</body>

</html>


