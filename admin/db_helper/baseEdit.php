<?php

	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	//Insert what was posted from last form.
	$sql = "UPDATE Bases
	SET baseName='".$_POST[baseName]."',basePassword='".$_POST[pwd]."',baseScanPoints='".$_POST[baseScanPoints]."',baseTrivia='".$_POST[baseTrivia]."',baseAnswer='".$_POST[baseAnswer]."',lat='".$_POST[lat]."',longitude='".$_POST[long]."'
	 WHERE baseID=".$_POST[baseID]."";
	
	mysql_query($sql) or die(mysql_error());
	
	mysql_close($con);
	
	header("Location: ../addBases.php?edited=yes");
?>