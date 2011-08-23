<?php

session_start();
header("Cache-control: private");
if ($_SESSION["access"] != "granted") {
	header("Location: ./login.php");
}

?>