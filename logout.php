<?php
//logout nav div redirects here
//Destroys Session and redirects to index.php
include 'config.php';
session_start();
session_destroy();
header('Location:index.php');
?>