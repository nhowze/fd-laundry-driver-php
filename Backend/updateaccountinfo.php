<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';


require_once('../includes/stripe-php-master/init.php');

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

function correctImageOrientation($filename) {
	if (function_exists('exif_read_data')) {
		$exif = exif_read_data($filename);
		if($exif && isset($exif['Orientation'])) {
			$orientation = $exif['Orientation'];
			if($orientation != 1){
				$img = imagecreatefromjpeg($filename);
				$deg = 0;
				switch ($orientation) {
					case 3:
						$deg = 180;
						break;
					case 6:
						$deg = 270;
						break;
					case 8:
						$deg = 90;
						break;
				}
				if ($deg) {
					$img = imagerotate($img, $deg, 0);
				}
				// then rewrite the rotated image back to the disk as $filename
				imagejpeg($img, $filename, 95);
			} // if there is some rotation necessary
		} // if have the exif orientation info
	} // if function exists
}

error_reporting(E_ERROR);

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 4 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM Drivers WHERE email = '".$_POST['email']."' AND id <> ".$row['id']." ";
$results = mysqli_query($mysqli, $sql);
//$email = mysqli_fetch_assoc($result);


if($results->num_rows > 0){
	
	$_SESSION['accountf'] = "The email address you chose is already taken.";
	header('Location: ../account.php');
	
	die();
	
}



function lookup_cnam($phonenum) {
	$username = "nhowze";
	$password = "93nr3fc4";
	
	$url = "https://api.data24-7.com/v/2.0?user=$username&pass=$password&api=T&p1=$phonenum";
	$xml = simplexml_load_file($url) or die("feed not loading");
	
	if($xml->results->result[0]->wless == "y"){
		$smsaddress = $xml->results->result[0]->sms_address;
		
	}else{
		
		$smsaddress = "error";
		
	}
	return($smsaddress);
	
	
}



if(!isset($_POST['username'])){
	
	$_POST['username'] = $_SESSION['username'];
	
}



if($row['Phone'] != $_POST['phone']){


	$answer = lookup_cnam($_POST['phone']);

	if($answer!= "error"){
		
		$code = rand(100000,999999);
		$mysqli->query("UPDATE Drivers SET Phone= '".$_POST['phone']."', Phone_Confirmed  = 'False', SMS_Address = '".$answer."', Phone_Code = '".$code."', username  = '".$_POST['username']."' WHERE username = '".$_SESSION['username']."' ");
		
		
		
		//send sms text for confirmation
		
		$to=$answer."\r\n";
		$subject="Confirmation Code";
		$body="Your confirmation code is ".$code;
		
		
	
		$mail             = new PHPMailer(); // defaults to using php "mail()"
	
	
		$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);
		$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
		$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);
		$mail->AddAddress($to, $row['Name']);
		
		$mail->Subject    = $subject;
		
		$mail->isHTML(true);  
		$mail->Body    = $body;
		$mail->AltBody = $body;
	
	
		if(!$mail->Send()) {


		}
		
		
	}else{
		
		$_SESSION['accountf'] = "Error: Please enter a valid mobile number.";
		echo'<script>
window.location.href = "../account.php";
</script>';
		
		die();
	}

}





$sql = "SELECT * FROM Drivers WHERE username = '".$_POST['username']."' AND id <> ".$row['id']." ";
$resultus = mysqli_query($mysqli, $sql);


if ($resultus->num_rows == 0) {


try {
	
	\Stripe\Stripe::setApiKey($keys['Key']);


if($_FILES["fileToUpload"]["name"] != ""){
	
	

	
	
	$tfname = "../accountfiles/";
	
	$target_dir = $_SERVER["DOCUMENT_ROOT"]."/Drivers/accountfiles/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$temp = explode(".", $_FILES["fileToUpload"]["name"]);
	$newfilename = $tfname.round(microtime(true)) . '.' . end($temp);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			//   echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			
			$uploadOk = 0;
		}
	}
	
	
	// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
			&& $imageFileType != "GIF") {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename)) {
					correctImageOrientation($newfilename);
					
					if($_POST['email'] == ""){
						
						$email = "";
					}else{
						
						$email = $_POST['email'];
					}
					
					if($_POST['phone'] == ""){
						
						$phone = "";
					}else{
						
						$phone = $_POST['phone'];
					}
					
					
					$tfname2 = str_replace("../","",$newfilename);
					
					$mysqli->query("UPDATE Drivers SET Profile_Pic = '".$tfname2."',email ='".$email."',Phone= '".$phone."', username  = '".$_POST['username']."' WHERE username = '".$_SESSION['username']."' ");
					$mysqli->query("UPDATE Driver_Transfer_History SET Username  = '".$_POST['username']."' WHERE Username = '".$_SESSION['username']."' ");
					$mysqli->query("UPDATE OrderGroup SET DriverPickup_Username  = '".$_POST['username']."' WHERE DriverPickup_ID = ".$row['id']." ");
					$mysqli->query("UPDATE OrderGroup SET DriverDeliver_Username  = '".$_POST['username']."' WHERE DriverDeliver_ID = ".$row['id']." ");
					$_SESSION['username'] = $_POST['username'];
					
					$oldfile = $row['Profile_Pic'];
					if($oldfile != ""){
						if (!unlink($oldfile))
						{
							echo ("Error deleting $oldfile");
						}
						else
						{
							echo ("Deleted $oldfile");
						}
					}
					
					
					
					
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
			
}else{
	
	
	
	if($_POST['email'] == ""){
		
		$email = "";
	}else{
		
		$email = $_POST['email'];
	}
	
	if($_POST['phone'] == ""){
		
		$phone = "";
	}else{
		
		$phone = $_POST['phone'];
	}
	
	
	$mysqli->query("UPDATE Drivers SET email ='".$email."',Phone= '".$phone."', username  = '".$_POST['username']."' WHERE username = '".$_SESSION['username']."' ");
	$mysqli->query("UPDATE Driver_Transfer_History SET Username  = '".$_POST['username']."' WHERE Username = '".$_SESSION['username']."' ");
	$mysqli->query("UPDATE OrderGroup SET DriverPickup_Username  = '".$_POST['username']."' WHERE DriverPickup_ID = ".$row['id']." ");
	$mysqli->query("UPDATE OrderGroup SET DriverDeliver_Username  = '".$_POST['username']."' WHERE DriverDeliver_ID = ".$row['id']." ");
	$_SESSION['username'] = $_POST['username'];
}


}catch (Exception $e) {
	$error = $e->getMessage();
	
	//echo($error);
	
}


}else if($resultus->num_rows > 0){
	
	
	$_SESSION['accountf'] = "The username you chose is already taken.";
	
}

header('Location: ../account.php');
?>