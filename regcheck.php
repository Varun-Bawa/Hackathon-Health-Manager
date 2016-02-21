<?php
//register.html form redirects here
//Inserts value to 'users' table to Register Users
include 'config.php';

$email		=  $_POST['email'];
$name 		=  $_POST['name'];
$dob 		=  $_POST['dob'];
$pass1  	=  $_POST['pass1'];
$pass2  	=  $_POST['pass2'];
$address 	=  $_POST['address'];
$phone  	=  $_POST['phone'];
//Redirecting Wrong Password to register-quiz.html
if($pass1!=$pass2)
{
	echo "	<script>
			alert('Password does not match');
			window.location.href='register.html';
			</script>";
}
else
{
	//Inserting Values to table 'users'!!
$ent  =mysql_query("INSERT into users (email,password) values ('$email','$pass1')");
$enter=mysql_query("INSERT into details (email,Name,DOB,Phone,Address) values('$email','$name','$dob','$phone','$address')") or die(mysql_error());
$link = "uploads/reports/".$email;
$dir = mkdir($link, 0777, true);
if($enter)
{
	echo "	<script>
			alert('Registered Successfully');
			window.location.href='index.php';
			</script>";
}
else
{	
	$chk= mysql_query("SELECT * FROM users WHERE email='".$email."'");
	$cou=mysql_num_rows($chk);
	if($cou != 0)
	{
		echo "<script>alert('Email already Registered');window.location ='register.html';</script>";
	}
	/*else
	{
	echo "	<script>
			alert('Required Fields Empty, Try Again');
			window.location.href='register.html';
			</script>";
	}*/
}
}
?>