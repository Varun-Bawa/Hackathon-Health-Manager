<?php
//index.php login form redirect here
//Check corresponding entry of user in table 'users' Entry in 'users' table is made via register.html
include 'config.php';
session_start();
$email=$_POST['email'];
$pass=$_POST['password'];
$chk= mysql_query("SELECT * FROM users WHERE email='".$email."' AND password='".$pass."'") or die("Could not execute query");
$arr=mysql_fetch_array($chk);
$cou=mysql_num_rows($chk);
if($cou == 0)
{
	echo "<script>alert('No Entry for Corresponding Email and Password');window.location ='index.php';</script>";
}
else
{	
	$chk1= mysql_query("SELECT * FROM details WHERE email='".$email."'") or die(mysql_error());
	$arr1= mysql_fetch_array($chk1);
	$name = $arr1['Name'];
	$_SESSION['email']=$email;
	$_SESSION['name']=$name;
	header('Location: index.php');
}
?>