<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('../LoginSystem-CodeCanyon/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';





function get_distance_between_points($latitude1, $longitude1, $latitude2, $longitude2) {
    $latitude1 = floatval($latitude1);
    $longitude1 = floatval($longitude1);
    $latitude2 = floatval($latitude2);
    $longitude2 = floatval($longitude2);
    
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('miles'); 
    }
    
    
    
    function getLatLong($address){
        if(!empty($address)){
            //Formatted address
            $formattedAddr = str_replace(' ','+',$address);
            //Send request and receive json data by address
<<<<<<< HEAD
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
=======
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
>>>>>>> 1af1fad... 1.0
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            $data['latitude']  = $output->results[0]->geometry->location->lat;
            $data['longitude'] = $output->results[0]->geometry->location->lng;
            
            //Return latitude and longitude of the given address
            if(!empty($data)){
<<<<<<< HEAD
                //echo('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
=======
                //echo('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
>>>>>>> 1af1fad... 1.0
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    echo'<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


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


$sql = "SELECT * FROM OrderGroup WHERE (DriverPickup_Username = '".$_SESSION['username']."' AND Status = 'Driver In Transit' OR Status = 'Driver In Transit With Laundry') OR  (DriverDeliver_Username = '".$_SESSION['username']."' AND Status = 'Driver In Transit' OR Status = 'Driver In Transit With Laundry')";
$result = mysqli_query($mysqli, $sql);
$tresult = mysqli_fetch_assoc($result);

//echo($sql);


if($result->num_rows == 0){


echo'<div id="list"  style="padding:3%; margin:2%;">


';
					
$sql2=
"SELECT * FROM OrderGroup WHERE (Status = 'Approved' )
OR (Status = 'Laundry Complete' AND Delivery = 'True'   AND Unavailable = 'false' AND Payment_Status = 'Approved')
OR (Status = 'Laundry Complete' AND Delivery = 'True'  AND Payment_Status = 'Approved'  AND Unavailable = 'true' AND TIME(NOW())  NOT BETWEEN Delivery_Time AND Delivery_Time2 )
ORDER BY Date ASC, Pickup_Time ASC, Delivery_Time ASC ";


$result2 = mysqli_query($mysqli, $sql2);
					
					
						if ($result2->num_rows > 0) {
						    
						    
						
						    
						    	echo'<table id="trips" style="visibility: hidden;">';
						    
						
						while($row2 = $result2->fetch_assoc()) {
							
							$sql = "SELECT * FROM Laundromat WHERE ID = ".$row2['Laundromat_ID']." ";
							$laundromat= mysqli_query($mysqli, $sql);
							$laundromat= mysqli_fetch_assoc($laundromat);
							
							
							$sql = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
							$customer= mysqli_query($mysqli, $sql);
							$customer= mysqli_fetch_assoc($customer);

							if($confirm['Phone'] != $laundromat['Phone'] && $confirm['Phone'] != $customer['Phone']){
							
							$l2Add = $row2['Address_Laundromat'];
							$l2City = $row2['City_Laundromat'];
							$l2State = $row2['State_Laundromat'];
							$l2Zip = $row2['Zip_Laundromat'];
							
							$c2Add = $row2['Address_Customer'];
							$c2Unit = $row2['Unit_Customer'];
							$c2City = $row2['City_Customer'];
							$c2State = $row2['State_Customer'];
							$c2Zip = $row2['Zip_Customer'];
							
					
						
							if($row2['Status'] == "Approved"){
								
								$sql22 = "SELECT * FROM users WHERE id = '".$row2['UserID']."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$launInfo = mysqli_fetch_assoc($result22);
								$address = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
								
								
							}else if($row2['Status'] == "Laundry Complete"){
								
								
								$sql22 = "SELECT * FROM Laundromat WHERE ID = '".$row2['Laundromat_ID']."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$launInfo = mysqli_fetch_assoc($result22);
								$address = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
							}
							
							
							
							
							$latLong = getLatLong($address);
							$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
							$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
							
							
							$distance = get_distance_between_points($latitude, $longitude, $_SESSION['newlatd'], $_SESSION['newlngd']);
							foreach ($distance as $unit => $value) {
								
								
								$sql22 = "SELECT * FROM users WHERE id = '".$uidd."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$userad = mysqli_fetch_assoc($result22);
								
								$useaddress = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
								
								$sql22 = "SELECT * FROM Laundromat WHERE ID = '".$Laundromat_ID."' ";
								
								$result22 = mysqli_query($mysqli, $sql22);
								$laundad = mysqli_fetch_assoc($result22);
								
								
								$lanaddress =  $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
								
								
								$fromadd = $useaddress;
								$toadd = $lanaddress;
								$fromadd = urlencode($fromadd);
								$toadd = urlencode($toadd);
								
<<<<<<< HEAD
								$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
=======
								$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
>>>>>>> 1af1fad... 1.0
								
								$dataadd2 = json_decode($dataadd2);
								
								$distanceadd2 = 0;
								foreach($dataadd2->rows[0]->elements as $roadadd2) {
									$timeadd2 = $roadadd2->duration->value;
									$distanceadd2 += $roadadd2->distance->value;
								}
								
								$milesadd2 = $distanceadd2 * 0.000621371;
								$milesadd2 = number_format($milesadd2,1);
								
								
								
								
								if($value <= 7){
							
							
							
						    
						$dat =  date('n-d-Y',strtotime($row2['Date']));
						
						
						if($row2['Status'] == "Approved"){
		
							$sqld = "SELECT * FROM users WHERE id = '".$row2['UserID']."' ";
							$resultd = mysqli_query($mysqli, $sqld);
							$launInfo = mysqli_fetch_assoc($resultd);
							
							
		
							$stat = "Pickup laundry from ".$launInfo['First_Name']." and deliver it to ".$row2['Name'].".";
		
						   $datt =  date('g:i A',strtotime($row2['Pickup_Time'])); 
						   

						    
						   $endl = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;  

						   
						   
$sqla = "SELECT * FROM Laundromat WHERE ID = '".$row2['Laundromat_ID']."' ";
$resulta = mysqli_query($mysqli, $sqla);
$rowa = mysqli_fetch_assoc($resulta);	
					
			    
$froml = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
						   
						   
						   
						   
						   
						   
						}else if($row2['Status'] == "Laundry Complete"){
						
						
						
						
$sqld = "SELECT * FROM Laundromat WHERE ID = '".$row2['Laundromat_ID']."' ";
$resultd = mysqli_query($mysqli, $sqld);
$launInfo = mysqli_fetch_assoc($resultd);
						    
$endl = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;  	



$sqla = "SELECT * FROM users WHERE id = '".$row2['UserID']."' ";
$resulta = mysqli_query($mysqli, $sqla);
$rowa = mysqli_fetch_assoc($resulta);	
					
			    
$froml = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip; 



						
				 $datt =  date('g:i A',strtotime($row2['Delivery_Time'])); 
						 
					
						 $stat = "Pickup Laundry from ".$row2['Name']."
						and deliver it to ".$rowa['First_Name'].".";
						 
						 
						
						}
						
						
						
		
						    
						    
$lat = $_SESSION['newlatd'];
$lng =$_SESSION['newlngd'];
$fromadd = $froml;
$toadd = $endl;
$fromadd = urlencode($fromadd);
$toadd = urlencode($toadd);
<<<<<<< HEAD
$dataadd = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$lat,$lng&destinations=$toadd&language=en-EN&sensor=false&key=");
=======
$dataadd = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$lat,$lng&destinations=$toadd&language=en-EN&sensor=false&key=");
>>>>>>> 1af1fad... 1.0

$dataadd = json_decode($dataadd);

$distanceadd = 0;
foreach($dataadd->rows[0]->elements as $roadadd) {
    $timeadd += $roadadd->duration->value;
    $distanceadd += $roadadd->distance->value;
}

$milesadd = $distanceadd * 0.000621371;
$milesadd = number_format($milesadd,1);

//2nd


<<<<<<< HEAD
$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
=======
$dataadd2 = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$fromadd&destinations=$toadd&language=en-EN&sensor=false&key=");
>>>>>>> 1af1fad... 1.0

$dataadd2 = json_decode($dataadd2);

$distanceadd2 = 0;
foreach($dataadd2->rows[0]->elements as $roadadd2) {
    $timeadd2 = $roadadd2->duration->value;
    $distanceadd2 += $roadadd2->distance->value;
}

$milesadd2 = $distanceadd2 * 0.000621371;
$milesadd2 = number_format($milesadd2,1);

	$duration = $timeadd2 / 60;					
						
		$duration = ceil($duration);				
		
		
		if($row2['Delivery'] == "False"){
			
			$row2['DeliveryTotal'] = round($row2['DeliveryTotal'], 2);
			
		}else{
			
		$row2['DeliveryTotal'] = round($row2['DeliveryTotal']/ 2, 2);
		
		}
		
		$row2['DeliveryTotal'] = number_format($row2['DeliveryTotal'],2);
		
						
						    
						     echo'
						     <style>
						     td{
						         font-size:85%;
						         
						     }
						     </style>
						     
						     <tr style="cursor:pointer;" onclick="submitForm(this);" class="trip">
					   

                            <td >
                            <form class="submitp" action="drivesession.php" method="get"  >
<input type="hidden" name="ordernum" value="'.$row2['OrderNum'].'">
<input type="hidden" name="dur" value="'.$duration.'">
<input type="hidden" name="intstruction" value="'.$stat.'">
						    Instructions: '.$stat.'
						     
						    
						    <table style="padding:0 !important; margin:0 !important;">
						    <tr style="background:rgba(0,0,0,0); border:none;">
						    <td>Distance Away: '.$milesadd.' mi</td>
 <td>Distance: '.$milesadd2.' mi</td>
</tr>

<tr style="border:none;">
 <td>Est Duration: '.$row2['Est_Duration'].' mins</td>
						    <td></td>
						    </tr>
                            </table>
                            </form>
						    </td>
						    
						    </tr>';
						    
						    
						    
								
						    
								}	
							}
							
						}


						}
						
						echo'</table>';
						
						
						
						}else{
						    
						    
						    echo'<div style="padding:2%; margin:2%; text-align:center;">No current trips available right now.</div>';
						    
						}
					
						
}else{   // if have current trip

$sqld = "SELECT * FROM OrderGroup WHERE (DriverPickup_Username = '".$_SESSION['username']."' OR DriverDeliver_Username = '".$_SESSION['username']."') AND Status LIKE 'Driver In Transit%'  ";
$result = mysqli_query($mysqli, $sqld);







echo'<table>';

while($row2 = $result->fetch_assoc()) {
    
	
	
	$sql22 = "SELECT * FROM users WHERE id = ".$row2['UserID']." ";
	
	$result22 = mysqli_query($mysqli, $sql22);
	$user = mysqli_fetch_assoc($result22);
	
	
	
	if($row2['Laundry_Complete'] == 0){
		
		
		if($row2['Status'] == "Driver In Transit"){
			
			$stat = "Pickup laundry from ".$user['First_Name']." and deliver it to ".$row2['Name'].".";
			
		}else if($row2['Status'] == "Driver In Transit With Laundry"){
			
			
			$stat = "Drop off  ".$user['First_Name']."'s laundry at ".$row2['Name'].".";
			
			
		}
		
		
		
		$mil = $row2['PickupMiles'];
		
		
	} else if($row2['Laundry_Complete'] == 1){
		
		
		
		if($row2['Status'] == "Driver In Transit"){
			
		$stat = "Pickup Laundry from ".$row2['Name']."
						and deliver it to ".$user['First_Name'].".";
		
		}else if($row2['Status'] == "Driver In Transit With Laundry"){
			
			$stat = "Return laundry back to ".$user['First_Name'].".";
			
			
		}
		
		
		$mil = $row2['DeliverMiles'];
	}
	
	


$row2['DeliveryTotal'] = $row2['DeliveryTotal'] / 2;
$row2['DeliveryTotal'] = round($row2['DeliveryTotal'], 2);
$row2['DeliveryTotal'] = number_format($row2['DeliveryTotal'],2);

echo'<tr style="cursor:pointer;" onclick="submitCurrentForm(this);">
 <td >
 <form class="submitp"  method="get" action="currenttrip.php">

<input type="hidden" name="dur" value="'.$mil.'">
<input type="hidden" name="total" value="'.$row2['DeliveryTotal'].'">
<input type="hidden" name="intstruction" value="'.$stat.'">
<input type="hidden" name="ordernum" value="'.$row2['OrderNum'].'"><br>
						    Instructions: '.$stat.'
						     
						    
						    <table style="padding:0 !important; margin:0 !important;">
						    <tr style="background:rgba(0,0,0,0); border:none;">
						    <td>Distance: '.$mil.' mi</td>
						    <td></td>
						    </tr>
						    </table></form>
						    </td>
</tr>';

}

echo'</table>';

}
						
			echo'</div>';			
						
						
						
								

?>
</div>


<script>
		
$("tr")
    .click(function(e){
        
 $(this).find(".submitp").submit();  

    });


$( document ).ready(function() {


    $('#trips tr.trip:not(:first)').remove();


    $('#trips tr.trip:first-child').find('form.submitp').attr('id', 'mytrip');
    $('#trips tr.trip:first-child').find('form.submitp').submit();

   }); 

</script>

