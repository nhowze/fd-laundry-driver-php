<?php
//session_start();

include_once("cooks.php");

include_once("db.php");


	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require '../PHPMailer-master/src/Exception.php';
	require '../PHPMailer-master/src/PHPMailer.php';
	require '../PHPMailer-master/src/SMTP.php';
include '../simple_html_dom.php';

$con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
or die ("Could not connect to mysql because ".mysqli_error());

mysqli_select_db($con,$db_name)  //select the database
or die ("Could not select to mysql because ".mysqli_error());

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($con, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);



//prevent sql injection
//$username=mysql_real_escape_string($_POST["username"]);
$password = mysqli_real_escape_string($con,$_POST["password1"]);
$username = $_SESSION['username'];

//check if user is in reset process
$query = "select * from " . $table_name . " where username='$username'  and activ_status='2'";
$result = mysqli_query($con,$query) or die('error');
$row = mysqli_fetch_array($result);
$email = $row['email'];

if (mysqli_num_rows($result)) {
   //pwd = crypt($password);
   if(phpversion() >= 5.5)
			{
				$pwd=password_hash($password,PASSWORD_DEFAULT);
			}
	else
			{
				$pwd = crypt($password,'987654321');   //Hash used to suppress  PHP notice
			}
   
    $query = "update " . $table_name . "	 set password='$pwd' , activ_status=1 where username='$username'";
    $result = mysqli_query($con,$query) or die('error');


    //send email for the user with password

    $to = $email;
    $subject = $contactinf['Name']." | Password Reset";
   

$html = file_get_html("https://".$_SERVER['HTTP_HOST']."/Drivers/LoginSystem/resetsuccess.php");
         
           
           // first check if $html->find exists

$cells = $html->find('html');

if(!empty($cells)){
	
	
	foreach($cells as $cell) {
      
         $mail  = new PHPMailer(); // defaults to using php "mail()"
         
         
         
         $mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
         $mail->SetFrom($contactinf['Email'], $contactinf['Name']);
         $mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
         $address = $to;
         $mail->AddAddress($to, $row['First_Name']);
         
         $mail->Subject    = $subject;
         
         
         $mail->isHTML(true);
         $mail->Body= $cell->outertext;
         
         
         
         
         
         if(!$mail->Send()) {
         	
         	
         	
         }
    
    
    
    
    
     $_SESSION['errormessage'] = "Your password was successfully reset.";
    
      echo'<script>location.href = "../about-driver.php";</script>';
      
	}   
    
}
      
      
} else {
     $_SESSION['errormessage'] = "Cannot change password:User already active please login";
       echo'<script>location.href = "../about-driver.php";</script>';
     
}
?>