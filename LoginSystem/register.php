<?php

include_once("cooks.php");

//session_start();

	include_once("db.php");
	
	include '../includes/simple_html_dom.php';

	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require '../includes/PHPMailer-master/src/Exception.php';
	require '../includes/PHPMailer-master/src/PHPMailer.php';
	require '../includes/PHPMailer-master/src/SMTP.php';
	

	function lookup_cnam($phonenum) {
		$uname = "nhowze";
		$pname = "93nr3fc4";
		
		$url = "https://api.data24-7.com/v/2.0?user=$uname&pass=$pname&api=T&p1=$phonenum";
		$xml = simplexml_load_file($url) or die(); //die("feed not loading");
		
		if($xml->results->result[0]->wless == "y"){
			$smsaddress = $xml->results->result[0]->sms_address;
			
		}else{
			
			$smsaddress = "error";
			
		}
		return($smsaddress);
		
		
	}
	
	$answer = lookup_cnam($_POST["phone"]);
	
	if($answer == "error"){
		
		$_SESSION['errormessage'] = "Error: Please enter a valid mobile number.";
		echo'<script>location.href = "../register.php";</script>';
		die();
		
	}else{
		
		$sms = $answer;
		
	}
	
	 $con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
	or die ("Could not connect to mysql because ".mysqli_error());
mysqli_query($con,"SET NAMES 'utf8'");
	mysqli_select_db($con,$db_name)  //select the database
	or die ("Could not select to mysql because ".mysqli_error());


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($con, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


//prevent sql injection
$username=mysqli_real_escape_string($con,$_POST["username"]);
$password=mysqli_real_escape_string($con,$_POST["password"]);
$email=mysqli_real_escape_string($con,$_POST["email"]);
$fname=mysqli_real_escape_string($con,$_POST["fname"]);
$lname=mysqli_real_escape_string($con,$_POST["lname"]);
$phone=mysqli_real_escape_string($con,$_POST["phone"]);
$dob=mysqli_real_escape_string($con,$_POST["dob"]);
$code = rand(100000,999999);

//check if user exist already
$query="select * from ".$table_name." where username='$username'";
$result=mysqli_query($con,$query) or die();
if (mysqli_num_rows($result))
  {
      
     $_SESSION['errormessage'] = "Error: Username already exist";
  echo'<script>location.href = "../register.php";</script>'; 
      
 die();
  }
  //check if user exist already
$query="select * from ".$table_name." where email='$email'";
$result=mysqli_query($con,$query) or die();
if (mysqli_num_rows($result))
  {
      
      $_SESSION['errormessage'] = "Error: Email address already exist";
  echo'<script>location.href = "../register.php";</script>';
      
      
die();

  }
  
	$activ_key = sha1(mt_rand(10000,99999).time().$email);
	
	if(phpversion() >= 5.5)
			{
				$hashed_password=password_hash($password,PASSWORD_DEFAULT);
			}
	else
			{
				$hashed_password = crypt($password,'987654321');   //Hash used to suppress  PHP notice
			}
	
	
	
			if($username != '' && $fname != '' && $lname != '' && $code != '' && preg_match('/^[\w-]+$/', $username)  ){
	
	$query="insert into ".$table_name."(username,password,email,activ_key,First_Name,Last_Name,DOB,Phone,SMS_Address,Phone_Code,Terms) values ('$username','$hashed_password','$email','$activ_key','$fname','$lname','$dob','$phone','$sms','$code','True')";
	
	$_SESSION['errormessage'] = "Your account has successfully been created.";
	
	}else{
	    
	    	     $_SESSION['errormessage'] = "Invalid Username";
  echo'<script>location.href = "../register.php";</script>'; 
	    
	    
	}
	
	
	if (!mysqli_query($con,$query))
	  {
	 die(); //	die('Error: ' . mysqli_error());

	  }
	 
	  //send sms text for confirmation
	  
	  $to=$sms."\r\n";
	  $subject="Confirmation Code";
	  $body="Your confirmation code is ".$code;
	  
	  
	  
	 
	  
	  
	  
	  $mail  = new PHPMailer(); // defaults to using php "mail()"
	  
	  
	  
	  $mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
	  $address = $to;
	  $mail->AddAddress($to, $username);
	  
	  $mail->Subject    = $subject;
	  
	  
	  $mail->isHTML(true);
	  $mail->Body= $body;
	  
	  
	  
	  
	  
	  if(!$mail->Send()) {
	  	
	  	
	  	
	  }
	  
	  
	  
  //start email



$html = file_get_html("https://".$_SERVER['HTTP_HOST']."/Drivers/Emails/registrationemailtemplate.php");


// first check if $html->find exists

$cells = $html->find('html');

if(!empty($cells)){
	
	
	foreach($cells as $cell) {


$mail             = new PHPMailer(); // defaults to using php "mail()"

//$body             = "<a href='".$pdflink2."' target ='_blank'>View Report</a>";
//$body             = preg_replace('/\.([^\.]*$)/i','',$body);


$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$address = $email;
$mail->AddAddress($email, $row['First_Name']);

$mail->Subject    = "Welcome to ".$contactinf['Name']."! | Driver Registration";;


$mail->isHTML(true);
$mail->Body = $cell->outertext;

//$mail->AddAttachment($pdflink);      // attachment


if(!$mail->Send()) {
	
//	echo("Error! Please try again.");
	
}else{
	
//	echo("Successfully sent!");
	
}


	}
	
	
}

//end email 
    
         
         
         
         
         echo'<script>location.href = "../login.php";</script>';
	 
?>