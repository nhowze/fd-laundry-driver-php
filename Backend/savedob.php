<?php


include("../LoginSystem-CodeCanyon/cooks.php");

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';



//session_start();





$mysqli->query("UPDATE Drivers SET DOB = '".$_POST['dob']."' WHERE username = '".$_SESSION['username']."' ");





header('Location: ../backgroundcheck.php');



?>