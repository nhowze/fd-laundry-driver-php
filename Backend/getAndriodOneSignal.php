<?php 
include_once("LoginSystem-CodeCanyon/cooks.php");
//session_start();
include_once('LoginSystem-CodeCanyon/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


$_POST['User'] = str_replace('"',"",$_POST['User']);





$mysqli->query("UPDATE Drivers SET OneSignal = '".$_POST['ID']."' WHERE username = '".$_POST['User']."' ");






?>