<?php
	session_start();
	header("Cache-control: private");
	$_SESSION['access'] = "logged_out";
	header("Location: ./login.php");
?>