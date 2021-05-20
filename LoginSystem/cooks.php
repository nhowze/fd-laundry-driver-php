<?php

include_once '../includes/db_connect.php';

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
//ini_set('session.save_path', $_SERVER["DOCUMENT_ROOT"].'/Drivers/LoginSystem/cook');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100000000);



session_start();

$cookie_name = "delivrmatdr";
$cookie_value = $_SESSION['username'];


setcookie($cookie_name, $cookie_value, time() + 31556952, $_SERVER["DOCUMENT_ROOT"].'/Drivers/LoginSystem/cook', $_SERVER["SERVER_NAME"]."/Drivers/", TRUE, TRUE); // 86400 = 1 day


if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
	
	
	$_COOKIE["delivrmatdr"] = $_SESSION['username'];
	$_SESSION['login'] == true;
	
	$mysqli->query("UPDATE Drivers SET Last_Active = NOW() WHERE username = '".$_SESSION['username']."' ");
	
	
}





?>