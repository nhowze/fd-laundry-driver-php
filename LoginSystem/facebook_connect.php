<?php

include_once("cooks.php");
//session_start();
require_once('db.php');

$con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
or die ("Could not connect to mysql because ".mysqli_error());

mysqli_select_db($con,$db_name)  //select the database
or die ("Could not select to mysql because ".mysqli_error());

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($con, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


// Include the autoloader provided in the SDK
require_once __DIR__ . '/social/facebook/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

	include '../includes/simple_html_dom.php';

	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require '../includes/PHPMailer-master/src/Exception.php';
	require '../includes/PHPMailer-master/src/PHPMailer.php';
	require '../includes/PHPMailer-master/src/SMTP.php';

$redirectURL = $url.'/facebook_connect.php'; //Callback URL




$fbPermissions = array('email');  //Optional permissions

// Create our Application instance (replace this with your appId and secret).
$fb = new Facebook(array(
    'app_id' => $fbappid,
    'app_secret' => $fbsecret,
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

//echo($redirectURL);

if(isset($_GET['state'])){
    
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
    
}
// Try to get access token
try {
    // Already login
    if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];
    } else {
        $accessToken = $helper->getAccessToken('https://'.$_SERVER['HTTP_HOST'].'/Drivers/LoginSystem/facebook_connect.php');
    }
 
    if (isset($accessToken)) {
        if (isset($_SESSION['facebook_access_token'])) {
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        } else {
            // Put short-lived access token in session
            $_SESSION['facebook_access_token'] = (string) $accessToken;
 
            // OAuth 2.0 client handler helps to manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();
 
            // Exchanges a short-lived access token for a long-lived one
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
 
            // Set default access token to be used in script
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
 
        // Redirect the user back to the same page if url has "code" parameter in query string
        if (isset($_GET['code'])) {

            // Getting user facebook profile info
            try {
            	$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,id,gender,locale,picture.width(720)');
            	$fbUserProfile = $profileRequest->getGraphNode()->asArray();
            	// Here you can redirect to your Home Page.
            	// echo "<pre/>";
            	
            	$fid =  $fbUserProfile['id'];
               // print_r($fbUserProfile);
				$fname = $fbUserProfile['first_name'];
				$lname = $fbUserProfile['last_name'];
				
				
				$pic ="//graph.facebook.com/".$fid."/picture?type=large";
				
			
				$emailid = $fbUserProfile['email'];
				$name = "user".$fid;
				$query = "select * from " . $table_name_social . " where email='$emailid' and source='facebook'";
				$result = mysqli_query($con,$query) or die('error');
				if (mysqli_num_rows($result)) {
				//do nothing
				
					$query = "UPDATE Drivers SET Profile_Pic = '".$pic."' WHERE username = '".$name."' ";
					if (!mysqli_query($con,$query)) {
						die('Error: ' . mysqli_error());
						
					}
					
					
					} else {
					    
					    
						if($name != '' &&  !preg_match('/[\'^�$%&*()}{@#~?><>,|=_+�-]/', $name) && !preg_match('/[\'^�$%&*()}{@#~?><>,|=_+�-]/', $fname) &&  !preg_match('/[\'^�$%&*()}{@#~?><>,|=_+�-]/', $lname) ){
						$query = "insert into " . $table_name_social . "(username,email,source,First_Name,Last_Name) values ('$name','$emailid','facebook','$fname','$lname')";
						
						
						$sql = "insert into " . $table_name . "(username,email,First_Name, Last_Name, Profile_Pic,activ_status) values ('$name','$emailid','$fname','$lname','$pic',1)";
						mysqli_query($con,$sql);
						
						
						
						
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
$address = $emailid;
$mail->AddAddress($emailid, $row['First_Name']);

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
						
						
						
						
						
						
					    	}else{
					    	    
					    	    
	 $_SESSION['errormessage'] = "There was an error while connecting to Facebook..";
  echo'<script>location.href = "../register.php";</script>'; 
					    	    
					    	}
						
						//echo($sql);

						if (!mysqli_query($con,$query)) {
							die('Error: ' . mysqli_error());

						}
					}
				    $_SESSION['fb_access_token'] = $accessToken;
					$_SESSION['username'] = $name;
					header('Location: ../confirm.php');
				
				
            } catch (FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // Redirect user back to app login page
                header("Location: ./");
                exit;
            } catch (FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        }
    } else {
        // Get login url
 
$loginURL = $helper->getLoginUrl('https://'.$_SERVER['HTTP_HOST'].'/Drivers/LoginSystem/facebook_connect.php', $fbPermissions);
        //  $_SSESION['tes'] = $loginURL;
	//	echo $loginURL;
        header("Location: " . $loginURL);
      
    }
} catch (FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
/* 


// Login or logout url will be needed depending on current user state.
if ($user) {
    $logoutUrl = $facebook->getLogoutUrl();
} else {
    $loginUrl = $facebook->getLoginUrl(
        array('scope' => 'email'));
}


if (!$user) {
    header('location:' . $loginUrl);
}


if ($user) {
	
    $emailid = $user_profile['email'];
    $name = $user_profile['first_name'] . $user_profile['last_name'];
    $query = "select * from " . $table_name_social . " where email='$emailid' and source='facebook'";
    $result = mysqli_query($con,$query) or die('error');
    if (mysqli_num_rows($result)) {
//do nothing
    } else {
        $query = "insert into " . $table_name_social . "(username,email,source) values ('$name','$emailid','facebook')";

        if (!mysqli_query($con,$query)) {
            die('Error: ' . mysqli_error());

        }
    }

    $_SESSION['fb_access_token'] = $facebook->getAccessToken();
    $_SESSION['username'] = $name;
    header('Location: members.php');
    //header('Location: index.php');
} */


?>
  