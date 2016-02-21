<?php
include 'config.php';
session_start();

$email = $_SESSION['email'];

$que = mysql_query("SELECT * from details where email='".$email."'") or die(mysql_error());
$arr = mysql_fetch_array($que);

$diseases = $arr[5];

$count = substr_count($diseases, ',');
$disarr = array();
$disarr = (explode(",",$diseases));
for($a=0;$a<=$count;$a++)
{
	$localQue = mysql_query("SELECT * from cures where Diseases='".$disarr[$a]."'");
	$sol = mysql_fetch_array($localQue);
	$med = $sol[1];
	$time = $sol[2];
	$num = $sol[3];
	echo "Disease|".$disarr[$a]."<br>"."Medicine|".$med."<br>"."Time|".$time."<br>".$num." Times a Day<br>";
}
?>