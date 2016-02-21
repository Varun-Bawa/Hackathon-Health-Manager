<?php
//register.html form redirects here
//Inserts value to 'users' table to Register Users
include 'config.php';
session_start();

$email		=  $_SESSION['email'];
$diseases 	=  $_POST['diseases'];
$date 		=  $_POST['date'];


	//Inserting Values to table 'details'!!
$enter  =mysql_query("UPDATE details SET Diseases='$diseases' , LastUpdate='$date' WHERE email='".$email."'") or die(mysql_error());
if($enter)
{
	echo "	<script>
			alert('Thank-You, Here is your Advice');
			window.location.href='index.php';
			</script>";
}
?>