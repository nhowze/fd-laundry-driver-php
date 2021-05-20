<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('../LoginSystem-CodeCanyon/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
 




$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['ordernum']."' ";
$result = mysqli_query($mysqli, $sql);
$ordergroup = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM users WHERE id = ".$ordergroup['UserID']." ";
$result = mysqli_query($mysqli, $sql);
$userinfo = mysqli_fetch_assoc($result);


$l2Add = $ordergroup['Address_Laundromat'];
$l2City = $ordergroup['City_Laundromat'];
$l2State = $ordergroup['State_Laundromat'];
$l2Zip = $ordergroup['Zip_Laundromat'];

$c2Add = $ordergroup['Address_Customer'];
$c2Unit = $ordergroup['Unit_Customer'];
$c2City = $ordergroup['City_Customer'];
$c2State = $ordergroup['State_Customer'];
$c2Zip = $ordergroup['Zip_Customer'];
$c2Instruct = $ordergroup['Special_Instructions'];

$ussaddress = $c2Add." ".$c2City.", ".$c2State." ".$c2Zip;
$ussaddress2 = $c2Add."<br>".$c2Unit."<br>".$c2City.", ".$c2State."<br> ".$c2Zip;

if($c2Instruct != ""){
	
	$ussaddress2 = $ussaddress2."<br>".$c2Instruct;
}

$launaddress = $l2Add." ".$l2City.", ".$l2State." ".$l2Zip;
$launaddress2 = $l2Add."<br> ".$l2City.", ".$l2State."<br> ".$l2Zip;




if($ordergroup['Laundry_Complete'] == 0){
	
	
	if($ordergroup['Status'] == "Driver In Transit"){
		
		$stat = "Pickup laundry from ".$userinfo['First_Name']." and deliver it to ".$ordergroup['Name'].".";
		
	}else if($ordergroup['Status'] == "Driver In Transit With Laundry"){
		
		
		$stat = "Drop off  ".$userinfo['First_Name']."'s laundry at ".$ordergroup['Name'].".";
		
		
	}
	
	
	
	
	
	
} else if($ordergroup['Laundry_Complete'] == 1){
	
	
	
	if($ordergroup['Status'] == "Driver In Transit"){
		
		$stat = "Pickup Laundry from ".$ordergroup['Name']."
						and deliver it to ".$userinfo['First_Name'].".";
		
	}else if($ordergroup['Status'] == "Driver In Transit With Laundry"){
		
		$stat = "Return laundry back to ".$userinfo['First_Name'].".";
		
		
	}
	
	
	
}



 ?>

 <?php 
 echo'
					
					
					<script>

					 $(function() {
						  $("form.transfer").submit(function(event) {
						    event.preventDefault(); // Prevent the form from submitting via the browser
						    var form = $(this);
						    $.ajax({
						      type: "post",
						      url: "Backend/transfer-items.php",
						      data: form.serialize()
						    }).done(function(data) {
						      // Optionally alert the user of success here...
						   
						$("#loaddiv").load("Ajax/currenttrip.php");

						    }).fail(function(data) {
						      // Optionally alert the user of an error here...
						    });

						  });


						});

						
					</script>
    
    
    
    <div id="loaddiv">';



    

    if($ordergroup['Laundry_Complete']== 0 && $ordergroup['Status'] == "Driver In Transit"){ // pickup initial from user
    	echo'<br>'.$stat.'<br><br>'.$ussaddress2.'<br>
	<br>
<h2>Confirm laundry pickup from '.$userinfo['First_Name'].'.</h2>';
    	
    	if(isset($_SESSION['wrongcode'])){
    		
    		echo'<h3 style="color:red">'.$_SESSION['wrongcode'].'</h3>';
    		
    	}
    	
echo'<form class="transfer">
<input type="hidden" name="track" value="1">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="initial">


<input type="hidden" name="code" value="initial"  ><br>
<input type="submit" value="Pickup Laundry">
</form>';
    }else if($ordergroup['Laundry_Complete'] == 0 && $ordergroup['Status'] == "Driver In Transit With Laundry"){ // Drop off laundry at laundromat
	
    	echo'<br>'.$stat.'<br><br>'.$launaddress2.'<br>
	<br>
<h2>Confirm laundry transfer to '.$ordergroup['Name'].'.</h2>';

    	if(isset($_SESSION['wrongcode'])){
    		echo'<h3 style="color:red">'.$_SESSION['wrongcode'].'</h3>';
    	}

echo'<form class="transfer">

<input type="hidden" name="track" value="0">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="final">

<input type="text" name="code" required><br>

<input type="submit" value="Transfer">
</form>';
	
	
    }else if($ordergroup['Laundry_Complete']== 1 && $ordergroup['Status'] == "Driver In Transit"){	// Pickup Laundry from laudromat
	
	
	
    	echo'<br>'.$stat.'<br><br>'.$launaddress2.'<br>
	<br>
<h2>Confirm laundry pickup from '.$ordergroup['Name'].'.</h2>';
    	
    	if(isset($_SESSION['wrongcode'])){
    		echo'<h3 style="color:red">'.$_SESSION['wrongcode'].'</h3>';
    	}
    	
echo'<form class="transfer">
<input type="hidden" name="track" value="1">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="initial">


<input type="text" name="code" required><br>
<input type="submit" value="Pickup Laundry">
</form>';
    	
	
    }else if($ordergroup['Laundry_Complete'] == 1 && $ordergroup['Status'] == "Driver In Transit With Laundry"){	// Drop off Laundry to user
	
	
    	echo'<br>'.$stat.'<br><br>'.$ussaddress2.'<br>
	<br>
<h2>Confirm laundry transfer to '.$userinfo['First_Name'].'.</h2>';
    	
    	if(isset($_SESSION['wrongcode'])){
    		echo'<h3 style="color:red">'.$_SESSION['wrongcode'].'</h3>';
    	}
    	
echo'<form class="transfer">

<input type="hidden" name="track" value="1">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<input type="hidden" name="desc" value="final">

<input type="text" name="code" required><br>

<input type="submit" value="Transfer">
</form>

'.$userinfo['First_Name'].' isn\'t available for a transfer?<br><br>

<script>
function validatedropoff(){
    var dropoff = document.getElementById("dropoffLocation").value;
    if(dropoff == ""){
        event.preventDefault()
        alert("Choose a drop off option.");
        
        return false;
    }


var file= document.getElementById("fileToUpload").files[0].name;
       var reg = /(.*?)\.(jpg|jpeg|png|gif|GIF|PNG|JPEG|JPG)$/;
       if(!file.match(reg))
       {

event.preventDefault();
    	   alert("Invalid File");
    	   return false;
       }


    
}

</script>



<form method="post" action="Backend/dropoff.php" onsubmit="validatedropoff()" enctype="multipart/form-data">
<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
<select name="dropoffLocation" id="dropoffLocation" required>
<option value="">Choose option 	&#8681;</option>
<option value="Doorstep">Leave At Doorstep</option>
<option value="Mailroom">Leave In Mailroom</option>
</select><br>
Take a picture of where you dropped off the laundry items.<br><br>


<table style="width:100%;"><tr style="border:none; background:rgba(0,0,0,0);">
<td style="width:50%; text-align:center; vertical-align:top;">
    <label class="button"  id="capture"  for="fileToUpload" style="box-shadow: none;"><i class="fas fa-camera" style="font-size:30px;"></i></label>
<input type="file" required name="fileToUpload"  style="display:none;"  id="fileToUpload" accept="image/*" capture></td>

<td style="width:50%; text-align:center; vertical-align:top;"><input type="submit" value="Drop off" id="dropoffBB" style="display:none;"></td></tr></table>
</form>';
	
	
    }else if($ordergroup['Laundry_Complete'] == 0 && $ordergroup['Status'] == "Received"){
	
	
    	
    	//update balance
    	$balance = $row['Balance']+ $ordergroup['PickupFee'];
    	
    	
    	$mysqli->query("UPDATE Drivers SET Balance = ".$balance."  WHERE username = '".$_SESSION['username']."' ");
    	//
    	
    	echo'<br><br><header class="major" style="padding:0; margin:0;">
								<img src="https://frontdoorlaundry.com/images/app-logo-transparent.png" style="width:50px;" alt="" /><h2>Your trip has been completed!</h2>
		
							</header>
<br><br>
<form method="post" action="finaltransfer.php">
    	
    	<input type="hidden" name="track" value="0">
    	<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
    
    			<input type="submit" value="Order Detail">
    			</form>';
	
	
    }else if($ordergroup['Laundry_Complete'] == 1 && $ordergroup['Status'] == "Order Complete"){
	
	
    	
    	
    	
    	//update balance driver
    	
    	$balance = $row['Balance'] + $ordergroup['DeliverFee'];
    	
    	
    	$mysqli->query("UPDATE Drivers SET Balance = ".$balance."  WHERE username = '".$_SESSION['username']."' ");
    	//
    	
    	
    	
    	
    	
	
    	echo'<br><br><header class="major" style="padding:0; margin:0;">
								<img src="https://frontdoorlaundry.com/images/app-logo-transparent.png" style="width:50px;" alt="" /><h2>Your trip has been completed!</h2>
		
							</header>
<br><br>
<form method="post" action="finaltransfer.php">
		
    	<input type="hidden" name="track" value="1">
    	<input type="hidden" name="oid" value="'.$ordergroup['ID'].'">
    		
    			<input type="submit" value="Order Detail">
    			</form>';
	
	
}



echo'</div>';



?>

<script>
function filechange(){

document.getElementById("dropoffBB").style.display= "block";
}

</script>
