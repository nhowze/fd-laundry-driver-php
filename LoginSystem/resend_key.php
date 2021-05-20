<?php 



include_once '../../includes/db_connect.php';

include_once '../../includes/functions.php';



$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";

$contactinf = mysqli_query($mysqli, $sqlct);

$contactinf = mysqli_fetch_assoc($contactinf);



use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



require '../PHPMailer-master/src/Exception.php';

require '../PHPMailer-master/src/PHPMailer.php';

require '../PHPMailer-master/src/SMTP.php';



?>include_once(

	

	<!DOCTYPE html>

<head>

    <title><?php echo $contactinf['Name']; ?> | Resend Key</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
include_once(
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

	    <link href="css/style.css" rel="stylesheet" media="screen">

</head>



<body>

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/jquery.validate.js"></script>

    <div class="logo">

         <h2><?php include('db.php'); echo $logotxt; ?></h2>



    </div>

    <form class="form-horizontal" id="login_form">

         <h2>User Activation</h2>



        <div class="line"></div>

        

<div class="messagebox">

            <div id="alert-message">

  

       

<?php

	include("db.php");

$con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server

or die ("Could not connect to mysql because ".mysqli_error());



mysqli_select_db($con,$db_name)  //select the database

or die ("Could not select to mysql because ".mysqli_error());



	if(isset($_GET['user'])) {

    $user=mysqli_real_escape_string($con,$_GET["user"]);

	}

	else

	die('Error');

	

	//check if user exist already

	$query="select * from ".$table_name." where username='$user'";

	$result=mysqli_query($con,$query) or die('error');

	if (mysqli_num_rows($result)) //if exist then check for activation status

	    {

		

		 

			 $query="select activ_key,email from ".$table_name." where username='$user' and activ_status in (1,2)";

		     $result=mysqli_query($con,$query) or die('error');

			 if(mysqli_num_rows($result))

			 {  

				echo "Account already activated";

			 }

			 else

			 {

			 //resend mail

			 $query="select activ_key,email from ".$table_name." where username='$user' and activ_status in (0,1,2)";

		     $result=mysqli_query($con,$query) or die('error');

			 

			 $db_field = mysqli_fetch_assoc($result);

				$activ_key=$db_field['activ_key'];

				$email=$db_field['email'];

				

				//send email for the user with password

	

	$to=$email;

	$subject="Activate Account";

	$body="Hi ".$user."<br /><br />".

	"Click the below link to confirm your account<br />".

	"<a href=\"$url/activate.php/?k=$activ_key\"> Confirm Account </a>".

	"<br /><br /><br/ > Link not working? Paste the below into your browser:<br />".

	$url."/activate.php/?k=".$activ_key."\  <br /><br />Thanks <br />";



	

	

	

	$mail  = new PHPMailer(); // defaults to using php "mail()"

	

	

	

	$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);

	$mail->SetFrom($contactinf['Email'], $contactinf['Name']);

	$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);

	$address = $to;

	$mail->AddAddress($to, $user);

	

	$mail->Subject = $subject;

	

	

	$mail->isHTML(true);

	$mail->Body= $body;

	

	

	

	

	

	if(!$mail->Send()) {

		

		

		

	}

	

	$_SESSION['errormessage'] = "User Account not yet confirmed. Check your mail for confirmation details.";

	

	echo'<script>location.href = "../login.php";</script>';

	

	

	

	 

				//echo "User Account not yet activated.Check your mail for activation details.";

			 }

			 

		 }	

	else

	{

	die("Username Doesn't exist");

	}



?>

</div>

</div>



</body>



</html>

