<?php


include_once '../includes/db_connect.php';
//include_once '../includes/functions.php';

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

	//Database configuration
$server=$_ENV['MYSQL_HOST'];
$db_user=$_ENV['MYSQL_USER'];
$db_pwd=$_ENV['MYSQL_PASSWORD'];
$db_name='nhowze_delivrmat';
$table_name='Drivers';
$table_name_social='users_socialdriver';
//email configuraion
$from_address= $contactinf['Email'];
//domain configuration
$url="https://www.".$_SERVER['HTTP_HOST']."/Drivers/LoginSystem";
//Admin username
$admin_user='admin';
$admin_password='';

//strings
//login
$msg_pwd_error='Password incorrect';
$msg_un_error='Username Doesn\'t exist';
$msg_email_1='User Account not yet activated.';
$msg_email_2='Click here to resend activation email';

//Registration form
$msg_reg_user='Username taken.Kindly choose different username';
$msg_reg_email='Email Already registered';
$msg_reg_activ='Activation code has been successfully sent to your Email Address';

//Admin login
$msg_admin_pwd='Incorect password';
$msg_admin_user='Username Doesn\'t exist';


//LOGO text
$logotxt="LOGO";

//Twitter Configuration
define('CONSUMER_KEY', 'CONSUMER_KEY_HERE');
define('CONSUMER_SECRET', 'CONSUMER_SECRET_HERE');
define('OAUTH_CALLBACK', $url.'/twitter_callback.php');

//Google Configuration
$Clientid='';
$Email_address='';
$Client_secret='';
$Redirect_URIs =$url.'/google_connect.php';
$apikeys='';

//facebook configuration
$fbappid='';
$fbsecret='';

?>
