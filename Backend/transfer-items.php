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


 
if(isset($_SESSION['wrongcode'])){
	unset($_SESSION['wrongcode']);
	
}


$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['ordernum']."' ";
$result = mysqli_query($mysqli, $sql);
$ordergroup = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM DriverRates WHERE ID = 1 ";
$ssq= mysqli_query($mysqli, $sql2);
$ssq= mysqli_fetch_assoc($ssq);

$_SESSION['code'] = $_POST['code'];

require_once '../includes/twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;


$expiretime = date("c",  strtotime('+24 hours', time()));


// Find your Account Sid and Auth Token at twilio.com/console
$sid    = "ACc9f057b1c506f046dba1e18e89d6e069";
$token  = "6e70b8bb2af1ea27c0e6969c1bd8418f";
$twilio = new Client($sid, $token);



if(isset($_POST['code']) || $_POST['code'] != ""){
	
	



//$nummuser = $ordergroup['User_CodeTimes'] + 1; 

	
	//$nummlaun = $ordergroup['Laundro_CodeTimes'] + 1; 


    

	if($ordergroup['Laundry_Complete']== 0 && $ordergroup['Status'] == "Driver In Transit" && $_POST['code'] == "initial"){ // pickup initial from user

    	
   
    		
    		if(isset($_SESSION['wrongcode'])){
    			unset($_SESSION['wrongcode']);
    		
    	}
    		$ss = "UPDATE OrderGroup SET Timestamp_UserPickup = NOW(), Status = 'Driver In Transit With Laundry'  WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		
  
    	
    	
    	
    	
	}else if($ordergroup['Laundry_Complete'] == 0 && $ordergroup['Status'] == "Driver In Transit With Laundry" && $_POST['code'] != "initial"){ // Drop off laundry at laundromat
	
    	if(isset($_SESSION['wrongcode'])){
    		unset($_SESSION['wrongcode']);
    		
    	}
	
    	
    	if($_POST['code'] == $ordergroup['Laundro_Code']){
    		
    		if(isset($_SESSION['wrongcode'])){
    			unset($_SESSION['wrongcode']);
    			
    		}
    		$ss = "UPDATE OrderGroup SET Timestamp_LaundromatDropoff = NOW(), Status = 'Received'   WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		//calculate trip total
    		
    		
    		
    		$sqlfin = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$fintime= mysqli_query($mysqli, $sqlfin);
    		$fintime = mysqli_fetch_assoc($fintime);
    		
    		
    		
    		$to_time = strtotime($fintime['Initial_Pickup_Start']);
    		$from_time = strtotime($fintime['Timestamp_LaundromatDropoff']);
    		
    		$triptime = round(abs($to_time - $from_time) / 60,2);
    		$a1 = $ordergroup['DeliveryTotal'] / 2;
    		$a2 = round($triptime * $ssq['Rate'], 2);
    		
    		$total = $a1 + $a2;
    		
    		
    		if($total < $fintime['Est_total']){
    			
    			$total = $fintime['Est_total'];
    			
    		}
    		
    		$ss = "UPDATE OrderGroup SET PickupFee = '".$total."'   WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		//OneSignal Start
    		
    		
    		$sql = "SELECT * FROM users WHERE username = '".$ordergroup['Username']."' ";
    		$result = mysqli_query($mysqli, $sql);
    		$rowUser = mysqli_fetch_assoc($result);
    		
    		
    		
    	
    		
    		$playerid = array();
if($rowUser['OneSignal'] != ""){

array_push($playerid,$rowUser['OneSignal']);

}

    		
    		
    		$fields = array(
    				'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
    				'include_player_ids' => $playerid,
    				'headings' => array("en" =>"Your laundry order will begin soon."),
    				'contents' => array("en"=>"".$ordergroup['Name']." has received your laundry!"),
    				'url' => 'https://delivrmat.com/Users/orderdetail.php?orderID='.$ordergroup['OrderNum'],
    				//'data' => array("openURL" => "https://delivrmat.com/Users/orderdetail.php?orderID=".$ordergroup['OrderNum']),
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
    		
    		// End OneSignal
    		
    		
    		
    
    		//driver notification
    		$sql = "SELECT * FROM Drivers WHERE username = '".$ordergroup['DriverPickup_Username']."' ";
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
    			
    			
$mysqli->query("INSERT INTO Driver_Bonus_History (DriverID, DATE, Trips, Reward) VALUES ('".$confirm['id']."', NOW(), '".$total."', '".$goalresults['Reward']."');");
    			
    			
    			
    			
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
    				'url' => 'https://delivrmat.com/Drivers/recent.php',
    				//'data' => array("openURL" => "https://delivrmat.com/Users/orderdetail.php?orderID=".$ordergroup['OrderNum']),
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
    		->sessions($ordergroup['PL'])
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
    		->sessions($ordergroup['PU'])
    		->update(array(
    				"status" => "closed"
    		)
    				);
    		
    		
    		
    		
    		
    	}else if($_POST['code'] != $ordergroup['Laundro_Code']  && $_POST['code'] != $ordergroup['User_Code']){
    		
    		
    	
    			
    			$nummlaun = $ordergroup['Laundro_CodeTimes'] + 1; 
    			$_SESSION['wrongcode'] = "Wrong Confirmation Code";
    			
    			$ss = "UPDATE OrderGroup SET Laundro_CodeTimes = ".$nummlaun."  WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    			$mysqli->query($ss);
    			
    			
    		
    		
    		
    		
    		
    		
    	}
    	
    	
    	
    	
    	
    	
	
    }else if($ordergroup['Laundry_Complete']== 1 && $ordergroup['Status'] == "Driver In Transit"){	// Pickup Laundry from laudromat
	
    	if(isset($_SESSION['wrongcode'])){
    		unset($_SESSION['wrongcode']);
    		
    	}
	
    	
    	if($_POST['code'] == $ordergroup['Laundro_Code']){
    		
    		if(isset($_SESSION['wrongcode'])){
    			unset($_SESSION['wrongcode']);
    			
    		}
    		$ss = "UPDATE OrderGroup SET Timestamp_LaundromatPickup = NOW(), Status = 'Driver In Transit With Laundry'  WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		
    		//update balance laundromat
    		$sql = "SELECT * FROM Laundromat WHERE ID = '".$ordergroup['Laundromat_ID']."' ";
    		$result = mysqli_query($mysqli, $sql);
    		$laun = mysqli_fetch_assoc($result);
    		
    		
    		$balance2 = $laun['Balance'] + $ordergroup['LaundromatFee'];
    		
    		$mysqli->query("UPDATE Laundromat SET Balance = ".$balance2."  WHERE ID = '".$laun['ID']."' ");
    		//
    		
    		
    		
    		
    		
    		//OneSignal Start
    		
    		
    		$sql = "SELECT * FROM users WHERE username = '".$ordergroup['Username']."' ";
    		$result = mysqli_query($mysqli, $sql);
    		$rowUser = mysqli_fetch_assoc($result);
    		
    		
    		
    	
    		
    		$playerid = array();
if($rowUser['OneSignal'] != ""){

array_push($playerid,$rowUser['OneSignal']);

}

    		
    		$fields = array(
    				'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
    				'include_player_ids' => $playerid,
    				'headings' => array("en" =>"Your laundry will be delivered soon."),
    				'contents' => array("en"=>"A Delivrmat driver has picked up your laundry!"),
    				'url' => 'https://delivrmat.com/Users/orderdetail.php?orderID='.$ordergroup['OrderNum'],
    				//'data' => array("openURL" => "https://delivrmat.com/Users/orderdetail.php?orderID=".$ordergroup['OrderNum']),
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
    		
    		// End OneSignal
    		
    		
    		
    		
    		
    		
    		
    		
    	}else if($_POST['code'] != $ordergroup['Laundro_Code']  && $_POST['code'] != $ordergroup['User_Code']){
    		
    		$nummlaun = $ordergroup['Laundro_CodeTimes'] + 1; 
    		
    		$_SESSION['wrongcode'] = "Wrong Confirmation Code";
    		$ss = "UPDATE OrderGroup SET Laundro_CodeTimes = ".$nummlaun."  WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    	}
    	
    	
    	

    	
	
    }else if($ordergroup['Laundry_Complete'] == 1 && $ordergroup['Status'] == "Driver In Transit With Laundry"){	// Drop off Laundry to user
	
    	if(isset($_SESSION['wrongcode'])){
    		unset($_SESSION['wrongcode']);
    		
    	}

    	
    	if($_POST['code'] == $ordergroup['User_Code']){
    		
    		
    		if(isset($_SESSION['wrongcode'])){
    			unset($_SESSION['wrongcode']);
    			
    		}
    		$ss = "UPDATE OrderGroup SET Timestamp_UserDropoff = NOW(), Status = 'Order Complete'  WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		
    		
    		
    		
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
    		
    		if($total < $fintime1['Est_total']){
    			
    			$total = $fintime1['Est_total'];
    			
    		}
    		
    		
    		$ss = "UPDATE OrderGroup SET DeliverFee = '".$total."', DropOff_Image = ''   WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    		
    
    		
    		
    		
    		//send receipt
    		
    		
    		$sqlus = "SELECT * FROM users WHERE id = '".$ordergroup['UserID']."' ";
    		$resultus = mysqli_query($mysqli, $sqlus);
    		$rowus = mysqli_fetch_assoc($resultus);
    		
    		
    		
    		$html = file_get_html("https://delivrmat.com/Users/Emails/emailreceipt.php?orderID=".$ordergroup['OrderNum']);
    		
    		
    		
    		
    		// first check if $html->find exists
    		
    		$cells = $html->find('html');
    		
    		if(!empty($cells)){
    			
    			
    			foreach($cells as $cell) {
    				
    				
    				$mail             = new PHPMailer(); // defaults to using php "mail()"
    				
    				//$body             = "<a href='".$pdflink2."' target ='_blank'>View Report</a>";
    				//$body             = preg_replace('/\.([^\.]*$)/i','',$body);
    				
    				
    				$mail->AddReplyTo("contactus@delivrmat.com","Delivrmat");
    				$mail->SetFrom('contactus@delivrmat.com', 'Delivrmat');
    				$mail->AddReplyTo("contactus@delivrmat.com","Delivrmat");
    				$address = $rowus['email'];
    				$mail->AddAddress($rowus['email']);
    				
    				$mail->Subject    = "Delivrmat Receipt";
    				
    				
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
    			
    			
$mysqli->query("INSERT INTO Driver_Bonus_History (DriverID, DATE, Trips, Reward) VALUES ('".$confirm['id']."', NOW(), '".$total."', '".$goalresults['Reward']."');");
    			
    			
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
    				'url' => 'https://delivrmat.com/Drivers/recent.php',
    				//'data' => array("openURL" => "https://delivrmat.com/Users/orderdetail.php?orderID=".$ordergroup['OrderNum']),
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
    		
    		
    		
    		
    	}else if($_POST['code'] != $ordergroup['User_Code'] && $_POST['code'] != $ordergroup['Laundro_Code']){
    		
    		$nummuser = $ordergroup['User_CodeTimes'] + 1; 
    		
    		$_SESSION['wrongcode'] = "Wrong Confirmation Code";
    		$ss = "UPDATE OrderGroup SET User_CodeTimes = ".$nummuser."  WHERE OrderNum = '".$_SESSION['ordernum']."' ";
    		$mysqli->query($ss);
    		
    		
    	}
    	
    	
	
	
}


}


unset($_POST['code']);

?>

