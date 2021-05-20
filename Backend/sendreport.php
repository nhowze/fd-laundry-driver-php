<?php



include_once("../LoginSystem-CodeCanyon/cooks.php");

//session_start();

include('../LoginSystem-CodeCanyon/db.php');

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';

require_once('../includes/stripe-php-master/init.php');

require_once '../includes/Libraries/vendor/autoload.php';



use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



require '../includes/PHPMailer-master/src/Exception.php';

require '../includes/PHPMailer-master/src/PHPMailer.php';

require '../includes/PHPMailer-master/src/SMTP.php';









if(isset($_SESSION['passconfirm'])){

	

	unset($_SESSION['passconfirm']);

}



$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";

$contactinf = mysqli_query($mysqli, $sqlct);

$contactinf = mysqli_fetch_assoc($contactinf);





$sql = "SELECT * FROM Drivers WHERE id = '".$_GET['drivrID']."' ";

$row= mysqli_query($mysqli, $sql);

$row= mysqli_fetch_assoc($row);



$mind = date('m/d/Y', strtotime($_GET['mindate']));

$maxd = date('m/d/Y', strtotime($_GET['maxdate']));



$mind2 = date('Y-m-d', strtotime($_GET['mindate']));

$maxd2 = date('Y-m-d', strtotime($_GET['maxdate']));





$pdfhtml = '<style>

		

table{

width:100%;

}

tr{

height:40px;



}

		

td, th{

text-align:center;

font-size:80%;

height:40px;

}

</style>



<div style="text-align:center;">';



if($_GET["report"] == "transfers"){			//transfers

	

	$stattrip = "Recent Transfers";

	

	$sql ="SELECT * FROM Driver_Transfer_History WHERE UserID = '".$row['id']."' AND (`Date` BETWEEN '".$mind2."' AND  '".$maxd2."') ORDER BY Date, Time";

	$result = mysqli_query($mysqli, $sql);



	

	if ($result->num_rows > 0) {

		

		

		$pdfhtml = $pdfhtml.'<img width="50" height "50" src="https://'.$_SERVER['SERVER_NAME'].'/Laundromats/images/delivrmat.png" style="display:block; text-align:center; margin-right: auto; margin-left:auto;">

<h2>'.$contactinf['Name'].' Payment Transfers</h2>

<table style="width:100%; text-align:center">

<tr><td colspan="3">Driver: '.$row['First_Name'].' '.$row['Last_Name'].'</td></tr>

<tr><td colspan="3">'.$mind.' - '.$maxd.'</td></tr></table>

<br>



<div style="width:100%; border-bottom:solid;"></div>







<table><tr><th>Date</th>

<th>Time</th>

<th>Amount</th></tr>';

		

		

		while($rowtable = $result->fetch_assoc()) {

			

			$rowtable['Time'] = date('g:i A', strtotime($rowtable['Time']));

			$rowtable['Date'] = date('m/d/Y', strtotime($rowtable['Date']));

			

			

			

			$rowtable['Amount'] = number_format($rowtable['Amount'], 2);

			

			

			$pdfhtml = $pdfhtml.'<tr>

					

					<td>'.$rowtable['Date'].'</td>

					<td>'.$rowtable['Time'].'</td>

					<td>$'.number_format($rowtable['Amount'], 2).'</td>

							

				</tr>';

			

		}

		

		$pdfhtml = $pdfhtml.'</table>';

	}else{

		

		$pdfhtml = $pdfhtml.'There were zero transfers initiated by '.$row['First_Name'].' '.$row['Last_Name'].' between '.$mind.' and '.$maxd.'. ';

		

	}

	

}else if($_GET["report"] == "trips"){			//trips

	

	$stattrip = "Recent Trips";

	

	

	$sql ="SELECT * FROM OrderGroup WHERE  DriverPickup_ID = '".$row['id']."' OR DriverDeliver_ID = '".$row['id']."' ORDER BY Date, Pickup_Time";

	$result = mysqli_query($mysqli, $sql);

	

	

	

	if ($result->num_rows > 0) {

		

		

		$pdfhtml = $pdfhtml.'<img width="50" height "50" src="https://'.$_SERVER['SERVER_NAME'].'/Laundromats/images/delivrmat.png" style="display:block; text-align:center; margin-right: auto; margin-left:auto;">

<h2>'.$contactinf['Name'].' Driver Report</h2>

<table style="width:100%; text-align:center">

<tr><td colspan="3">Driver: '.$row['First_Name'].' '.$row['Last_Name'].'</td></tr>

<tr><td colspan="3">'.$mind.' - '.$maxd.'</td></tr></table>

<br>

<div style="width:100%; border-bottom:solid;"></div>





<table><tr><th>Date</th><th>Time</th><th>Laundromat</th><th>Type</th><th>Distance</th><th>Est. Duration</th><th>Trip Duration</th><th>Est. Total</th><th>Trip Total</th></tr>';

		

		

		while($rowtable = $result->fetch_assoc()) {

			

			

			if($rowtable['DriverPickup_ID'] == $row['id']){ //pickup

				

				

				

				$rowtable['Date'] = date('m/d/Y', strtotime($rowtable['Date']));

				$rowtable['Time'] = date('g:i A', strtotime($rowtable['Time']));

				

				$to_time = strtotime($rowtable['Initial_Pickup_Start']);

				$from_time = strtotime($rowtable['Timestamp_LaundromatDropoff']);

				$duration = round(abs($to_time - $from_time) / 60,0);

				

				$estduration = round($rowtable['Est_Duration'], 0);

				

				

				$pdfhtml = $pdfhtml.'<tr>

<td>'.$rowtable['Date'].'</td>

<td>'.$rowtable['Time'].'</td>

<td>'.$rowtable['Name'].'</td>

<td>Customer &#x2192; Laundromat</td>

<td>'.number_format($rowtable['PickupMiles'], 1).' miles</td>

<th>'.$estduration.' mins</th>

<td>'.$duration.' mins</td>

<td>$'.number_format($rowtable['Est_total'], 2).'</td>

<td>$'.number_format($rowtable['PickupFee'], 2).'</td>

		

				</tr>';

				

			}

			

			if($rowtable['DriverDeliver_ID'] == $row['id']){		//deliver

				

				$rowtable['Date'] = date('m/d/Y', strtotime($rowtable['Date']));

				$rowtable['Time'] = date('g:i A', strtotime($rowtable['Time']));

				

				$to_time = strtotime($rowtable['Initial_Delivery_Start']);

				$from_time = strtotime($rowtable['Timestamp_UserDropoff']);

				$duration = round(abs($to_time - $from_time) / 60,0);

				$estduration = round($rowtable['Est_Duration'], 0);

				

				

				$pdfhtml = $pdfhtml.'<tr>

<td>'.$rowtable['Date'].'</td>

<td>'.$rowtable['Time'].'</td>

<td>'.$rowtable['Name'].'</td>

<td> Laundromat &#x2192; Customer</td>

<td>'.number_format($rowtable['DeliverMiles'], 1).' miles</td>

<th>'.$estduration.' mins</th>

<td>'.$duration.' mins</td>

<td>$'.number_format($rowtable['Est_total'], 2).'</td>

<td>$'.number_format($rowtable['DeliverFee'], 2).'</td>

 	</tr>';

				

			}

			

			

			

			

		}

		

		$pdfhtml = $pdfhtml.'</table>';

	}else{

		

		$pdfhtml = $pdfhtml.'There were zero trips completed by '.$row['First_Name'].' '.$row['Last_Name'].' between '.$mind.' and '.$maxd.'. ';

		

	}

	

	

	

	

}





$pdfhtml = $pdfhtml.'</div>';



$mpdf = new \Mpdf\Mpdf([

		'mode' => 'utf-8',

		//	'format' => [100, 200],

		'orientation' => 'P',

		'table_error_report' => false

]);







$pdflink = '../reports/'.rand().$row['id'].'.pdf';

$pdflink2 = 'https://'.$_SERVER['SERVER_NAME'].'/Drivers/'.$pdflink;



$mpdf->AddPage();

$mpdf->shrink_tables_to_fit=1;

$mpdf->WriteHTML($pdfhtml);

$mpdf->Output($pdflink,'F');

















$mail             = new PHPMailer(); // defaults to using php "mail()"



//$body             = "<a href='".$pdflink2."' target ='_blank'>View Report</a>";

//$body             = preg_replace('/\.([^\.]*$)/i','',$body);





$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);

$mail->SetFrom($contactinf['Email'],$contactinf['Name']);

$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);

$address = $row['email'];

$mail->AddAddress($row['email'], $row['Name']);



$mail->Subject    = $contactinf['Name']." Driver | $stattrip Report";

 





$mail->isHTML(true);

$mail->Body    = "Your request has finished processsing. Your report is attached. <a href='".$pdflink2."' target ='_blank'>View Report</a>";

$mail->AltBody = 'Your request has finished processsing. Your report is attached. <br>Link for report: '.$pdflink2;

$mail->AddAttachment($pdflink);      // attachment







if(!$mail->Send()) {

	

	$_SESSION['report'] = "There was an error sending your report. Please try again.";

	

}else{

	

	$_SESSION['report'] = "Your report was successfully sent!";

	

}





if($_GET["report"] == "transfers"){	

	

	header("Location: ../payments.php");

	

}else if($_GET["report"] == "trips"){

	

	header("Location: ../recent.php");

	



}







?>