<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('../LoginSystem-CodeCanyon/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once '../includes/Libraries/vendor/autoload.php';

include '../includes/simple_html_dom.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';






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

require_once '../includes/twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;

if($confirm['Terms'] != "True"){
	
	
	echo'<script>
window.location.href = "../agreement.php";
</script>';
	
	
}else if($confirm['Address'] == "" || $confirm['City'] == "" || $confirm['State'] == "" || $confirm['Zip'] == ""){
	
	
	echo'<script>
						window.location.href = "../setuphomeaddress.php";
			</script>';
	
}


if($confirm['Phone_Confirmed'] == "False" || $confirm['StripeAccount'] == ""){
	
	
	echo'<script>
						window.location.href = "../setupaccount.php";
			</script>';
	
}


if($confirm['Checkr_Status'] != "Approved" || $confirm['DOB'] == '0000-00-00'){
	echo'<script>
	window.location = "../backgroundcheck.php";
	</script>';
}



$target_dir = "../dropoffImages/";

$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$target_file= $target_dir . round(microtime(true)) . '.' . end($temp);

//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}
// Check if file already exists
if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				correctImageOrientation($target_file);

echo'<script>



    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);


    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }




function showPosition(position) {
   

    $.post("getlocation.php", {
latitude: position.coords.latitude,
longitude: position.coords.longitude
});


}


</script>';

$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['ordernum']."' ";
$result = mysqli_query($mysqli, $sql);
$ordergroup = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM DriverRates WHERE ID = 1 ";
$ssq= mysqli_query($mysqli, $sql2);
$ssq= mysqli_fetch_assoc($ssq);


$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);






$expiretime = date("c",  strtotime('+24 hours', time()));


// Find your Account Sid and Auth Token at twilio.com/console
$sid    = "ACc9f057b1c506f046dba1e18e89d6e069";
$token  = "6e70b8bb2af1ea27c0e6969c1bd8418f";
$twilio = new Client($sid, $token);




if($ordergroup['Laundry_Complete'] == 1 && $ordergroup['Status'] == "Driver In Transit With Laundry"){	// Drop off Laundry to user
	
   
$tfname2 = str_replace("../","",$target_file);
    	
    
	$ss = "UPDATE OrderGroup SET Timestamp_UserDropoff = NOW(), DropOff_Image = '".$tfname2."', Status = 'Order Complete',  DropOffLocation = '".$_POST['dropoffLocation']."'  WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		
    		
    		
    		
    		//send receipt
    		
    		
    		$sqlus = "SELECT * FROM users WHERE id = '".$ordergroup['UserID']."' ";
    		$resultus = mysqli_query($mysqli, $sqlus);
    		$rowus = mysqli_fetch_assoc($resultus);
    		
    		
    		
    		$html = file_get_html("https://".$_SERVER['SERVER_NAME']."/Users/Emails/emailreceipt.php?orderID=".$ordergroup['OrderNum']);
    		
    		
    		
    		
    		// first check if $html->find exists
    		
    		$cells = $html->find('html');
    		
    		if(!empty($cells)){
    			
    			
    			foreach($cells as $cell) {
    				
    				
    				$mail             = new PHPMailer(); // defaults to using php "mail()"
    				
    				
    				
    				
    				$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
    				$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
    				$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
    				$address = $rowus['email'];
    				$mail->AddAddress($rowus['email']);
    				
    				$mail->Subject    = $contactinf['Name']." Receipt";
    				
    				
    				$mail->isHTML(true);
    				$mail->Body    = $cell->outertext;
    				//	$mail->AddAttachment($pdflink);      // attachment
    				
    				
    				
    				if(!$mail->Send()) {
    					
    					//$_SESSION['report'] = "There was an error sending your report. Please try again.";
    					
    				}else{
    					
    					//$_SESSION['report'] = "Your report was successfully sent!";
    					
    				}
    				
    				
    				
    				
    				
    				
    				//	echo $cell->outertext;
    				
    				
    			}
    			
    		}
    		
    		
    		//end receipt
    		
    		
    		
    		
    		//calculate trip total
    		
    		
    		
    		$sqlfin1 = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$fintime1= mysqli_query($mysqli, $sqlfin1);
    		$fintime1 = mysqli_fetch_assoc($fintime1);
    		
    		
    		
    		$to_time = strtotime($fintime1['Initial_Delivery_Start']);
    		$from_time = strtotime($fintime1['Timestamp_UserDropoff']);
    		
    		$triptime = round(abs($to_time - $from_time) / 60,2);
    		$a1 = $ordergroup['DeliveryTotal'] / 2;
    		$a2 = round($triptime * $ssq['Rate'], 2);
    		
    		$total = $a1 + $a2;
    		
    		$ss = "UPDATE OrderGroup SET DeliverFee = '".$total."'   WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		
    
    		
    		//driver notification
    		$sql = "SELECT * FROM Drivers WHERE username = '".$ordergroup['DriverDeliver_Username']."' ";
    		$confirm= mysqli_query($mysqli, $sql);
    		$confirm= mysqli_fetch_assoc($confirm);
    		
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
    		
    		
    		$sql3 ="SELECT * FROM Trip_Goals WHERE Trips_Completed = '".$total."'";
    		
    		$result3 = mysqli_query($mysqli, $sql3);
    		$goalresults = mysqli_fetch_array($result3);
    		
    		if (mysqli_num_rows($result3) != 0) {
    			
    			//	$messageend= "Congratulations you have earned a $".$goalresults['Reward']." monthly bonus!";
    			
    			$newbalance = number_format($confirm['Balance'],2)+ number_format($goalresults['Reward'],2);
    			
    			$newbss = "UPDATE Drivers SET Balance = '".$newbalance."'  WHERE username = '".$confirm['username']."' ";
    			$mysqli->query($newbss);
    			
    			
    			$messageend= "Congratulations you have earned a $".$goalresults['Reward']." monthly bonus!";
    			
    			
    		}else{
    			
    			
    			
    			$sql2 ="SELECT * FROM Trip_Goals WHERE Trips_Completed > '".$total."' LIMIT 1";
    			$result2= mysqli_query($mysqli, $sql2);
    			$result2= mysqli_fetch_array($result2);
    			
    			$tripsleft = abs($result2['Trips_Completed'] - $total);
    			
    			
    			if($tripsleft == 1){
    				
    				$messageend= "Complete ".$tripsleft." more trip to earn a $".$result2['Reward']." bonus!";
    				
    			}else{
    				$messageend= "Complete ".$tripsleft." more trips to earn a $".$result2['Reward']." bonus!";
    				
    			}
    			
    			
    			
    			
    		}
    		
    		$playerid2 = array();
    		if($confirm['OneSignal'] != ""){
    			
    			array_push($playerid2,$confirm['OneSignal']);
    			
    		}
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		$title =  "Trip Completed                                                             ";
    		
    		$fields = array(
    				'app_id' => 'c228f8f4-96ca-448a-b192-55557a74ed03',
    				'include_player_ids' => $playerid2,
    				'headings' => array("en"=>$title),
    				'contents' => array("en" =>$messageend),
    				'url' => 'https://'.$_SERVER['SERVER_NAME'].'/Drivers/recent.php',
					
				);
    		
    		$fields = json_encode($fields);
    		//print("\nJSON sent:\n");
    		//print($fields);
    		
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    				'Authorization: Basic M2ZNDYtMjA4ZGM2ZmE5ZGFj'));
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    		curl_setopt($ch, CURLOPT_HEADER, FALSE);
    		curl_setopt($ch, CURLOPT_POST, TRUE);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    		
    		$response = curl_exec($ch);
    		curl_close($ch);
    		//print_r($response);
    		
    		// End Driver OneSignal
    		
    		
    		
    		//start User Notification
    		
    		
	$sql = "SELECT * FROM users WHERE id = '".$ordergroup['UserID']."' ";
$user= mysqli_query($mysqli, $sql);
$user= mysqli_fetch_assoc($user);
    		
    		
    		    		$playerid3 = array();
    		if($user['OneSignal'] != ""){
    			
    			array_push($playerid3,$user['OneSignal']);
    			
    		}
    	
    		
    		
    		
    		$title =  "Your laundry has been dropped off.";
    		$messageend = "Drop Off Location: ".$_POST['dropoffLocation']." ";
    		
    		$fields = array(
    				'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
    				'include_player_ids' => $playerid3,
    				'headings' => array("en"=>$title),
    				'contents' => array("en" =>$messageend),
    				'url' => 'https://'.$_SERVER['SERVER_NAME'].'/Users/orderdetail.php?orderID='.$ordergroup['OrderNum'],
					
				);
    		
    		$fields = json_encode($fields);
    		//print("\nJSON sent:\n");
    		//print($fields);
    		
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    				'Authorization: Basic M2ZNDYtMjA4ZGM2ZmE5ZGFj'));
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    		curl_setopt($ch, CURLOPT_HEADER, FALSE);
    		curl_setopt($ch, CURLOPT_POST, TRUE);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    		
    		$response = curl_exec($ch);
    		curl_close($ch);
    	//	print_r($response);
    		
    		// End Driver OneSignal
    		
    		
    		
    		
    		
    		
    		
    		
    		//end user notification
    		
    		
    		
    		
    		//close twilio session
<<<<<<< HEAD
<<<<<<< HEAD
    		$session = $twilio->proxy->v1->services("")
=======
    		$session = $twilio->proxy->v1->services("KSe7198a353437eebcd797ffd5c0ac1dfd")
>>>>>>> 1af1fad... 1.0
=======
    		$session = $twilio->proxy->v1->services("")
>>>>>>> 8d76903... 1.1
    		->sessions($ordergroup['DL'])
    		->update(array(
    				"status" => "closed"
    		)
    				);
    		
    		
    		//close session
<<<<<<< HEAD
<<<<<<< HEAD
    		$session = $twilio->proxy->v1->services("")
=======
    		$session = $twilio->proxy->v1->services("KSe7198a353437eebcd797ffd5c0ac1dfd")
>>>>>>> 1af1fad... 1.0
=======
    		$session = $twilio->proxy->v1->services("")
>>>>>>> 8d76903... 1.1
    		->sessions($ordergroup['DU'])
    		->update(array(
    				"status" => "closed"
    		)
    				);
    		
    		
    		
    		
    	}
    
    	echo'
    	
    	<script>
   	window.location.href = "https://'.$_SERVER['SERVER_NAME'].'/Drivers/recent.php";
    	
    	</script>
    	
    	
    	
    	';
    	
    	
			} else {
				echo'
						
    	<script>
    	window.location.href = "https://'.$_SERVER['SERVER_NAME'].'/Drivers/home.php";
						
    	</script>
						
						
						
    	';
			}
		}
    	
    	
    	
    	?>