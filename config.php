<?php
//Creating Connection to Database!
$con = mysql_connect("localhost", "root", "") or die("Could not connect to MySQL");
mysql_select_db("Hackathon") or die("Could not select db");
?>