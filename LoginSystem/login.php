<?php

include_once("cooks.php");

//session_start();
	include_once("db.php");
	$con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
	or die ("Could not connect to mysql because ".mysqli_error());

	mysqli_select_db($con,$db_name)  //select the database
	or die ("Could not select to mysql because ".mysqli_error());

	//prevent sql injection
	$username=mysqli_real_escape_string($con,$_POST["username"]);
	$password=mysqli_real_escape_string($con,$_POST["password"]);
	
		//decrypt password

	
	//check if user exist already
	$query="select * from ".$table_name." where username='$username'";
	$result=mysqli_query($con,$query) or die('error');
	if (mysqli_num_rows($result)) //if exist then check for password
	    {
		
		//Pickup password to compare with encrypted password
		$query="select password,email from ".$table_name." where username='$username'";
	    $result=mysqli_query($con,$query) or die('error');
		$db_field = mysqli_fetch_assoc($result);
		//3.3 $hashed_password=crypt($password,$db_field['password']);
		
		if(phpversion() >= 5.5)
			{
				if(password_verify($password, $db_field['password']))
					{
						
						//once password is verified migrate to password_hash from crypt
						if(strlen($db_field['password']) < 60)
						{
							$hashed_password=password_hash($password,PASSWORD_DEFAULT);
							$query = "update " . $table_name . "	 set password='$hashed_password' where username='$username' and email='$db_field[email]'";
							//echo $query;
							$result = mysqli_query($con,$query) or die('error updating password hash');
						}
						
						 $query="select * from ".$table_name." where username='$username'and activ_status in(1)";
						 $result=mysqli_query($con,$query) or die('error');
						 if(mysqli_num_rows($result))
						 {  
							 $_SESSION['login'] = true;
							 $_SESSION['username']=$username;


                                                         //Successful
                                                         echo'<script>location.href = "../confirm.php";</script>';
						//	 echo json_encode( array('result'=>1));
						 }
						 else
						 {

                                                    //   not activated

                                                        $_SESSION['errormessage'] = "Error: User Account not yet activated.Check your mail for activation details.";
                                                       echo'<script>location.href = "../login.php";</script>';

						
						 }
						 
					}
				else
					{
						

                                                 //wrong password

                                                        $_SESSION['errormessage'] = "Error: Username and password do not match";
                                                       echo'<script>location.href = "../login.php";</script>';


					}
				
			}
			else
			{
				$hashed_password=crypt($password,$db_field['password']);
					 $query="select * from ".$table_name." where username='$username' and password='$hashed_password'";
					 $result=mysqli_query($con,$query) or die('error');
					 if (mysqli_num_rows($result))  //if passwords match then check actvation status
					 {
						 $query="select * from ".$table_name." where username='$username' and password='$hashed_password' and activ_status in(1)";
						 $result=mysqli_query($con,$query) or die('error');
						 if(mysqli_num_rows($result))
						 {  
							 $_SESSION['login'] = true;
							 $_SESSION['username']=$username;

                                                         //Successful

                                                         echo'<script>location.href = "../confirm.php";</script>';
					//		 echo json_encode( array('result'=>1));
						 }
						 else
						 {
						 //   not activated

                                                        $_SESSION['errormessage'] = "Error: User Account not yet activated.Check your mail for activation details.";
                                                       echo'<script>location.href = "../login.php";</script>';
						 }
						 
					 }
					 else
					 {
					 //wrong password

                                                        $_SESSION['errormessage'] = "Error: Username and password do not match";
                                                       echo'<script>location.href = "../login.php";</script>';
					 }
						 
			}

		
		
		
		}
 		 
 	    
	else
	{


//   Username doesn't exist

                                                        $_SESSION['errormessage'] = "Error: Username Doesn't exist";
                                                       echo'<script>location.href = "../login.php";</script>';

	
	die();
	}

?>