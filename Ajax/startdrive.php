<?php

include_once("../LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('../LoginSystem-CodeCanyon/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';


if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) {

if(empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])){

if ( !isset($_SESSION['token'])) {

if ( !isset($_SESSION['fb_access_token'])) {

 header('Location: about.php');

exit;
}
}
}
}


$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_GET['myOrder']."' AND Laundry_Complete ='".$_GET['status']."' ";
$result = mysqli_query($mysqli, $sql);
$ordergroup = mysqli_fetch_assoc($result);


if($ordergroup['Status'] == "Driver In Transit" || $ordergroup['Status'] == "Driver In Transit With Laundry"){

echo'<p style="font-weight:bold;">This trip has already been claimed.</p>';

}else{

    echo'<input type="submit" value="Start Trip" style="background:#ed4933;" id="start">';

}



?>