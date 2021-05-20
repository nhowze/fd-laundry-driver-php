<?php



include_once("../LoginSystem-CodeCanyon/cooks.php");

//session_start();

include('../LoginSystem-CodeCanyon/db.php');

include_once '../includes/db_connect.php';

include_once '../includes/functions.php';







$sql = "SELECT * FROM Drivers WHERE username = '".$_SESSION['username']."' ";

$confirm= mysqli_query($mysqli, $sql);

$confirm= mysqli_fetch_assoc($confirm);





$sqlnum = "SELECT * FROM OrderGroup WHERE ID = '".$_POST['OrderID']."' ";

$resultnum = mysqli_query($mysqli, $sqlnum);

$ordersummary = mysqli_fetch_assoc($resultnum);





$mysqli->query("INSERT INTO Driver_Customer_Service (OrderNum, LaundromatID, DriverID, Issue, CustomerID)

VALUES ('".$_POST['OrderID']."', ".$ordersummary['Laundromat_ID'].", ".$confirm['id'].", '".$_POST['problem']."', ".$ordersummary['UserID'].")");





$_SESSION['ReportMessage'] = 'Thank you for reporting your issue. We will be contacting you via email asap.  Thanks for your patience.';



header("Location: ../home.php");





?>