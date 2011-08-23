<html>

<head>
<title>Base adder</title>
<style type="text/css">
<!--
body,td,th {
	color: #FFF;
}
body {
	background-color: #000;
}

a:link {
	color:#FC0;	
}

a:visited {
	color:#FC0;	
}

a:active {
	color:#FC0;	
}

a:hover {
	color:#FF0;	
}

tr { background-color: #333333}
  .initial { background-color: #333333; color:#000000 }
  .normal { background-color: #333333 }
  .highlight { background-color: #666666 }
  
-->
</style>


</head>

<body>
<?php
	/* Include the GoogleQR class */
	require_once 'GooglPHP.php';
	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	// Create Goo.gl link
	$strLongUrl = "http://www.urbanchallenge.com.au/index.php?q=" . $_POST['basePassword'];
	$strShortUrl = GooglPHP::shortURL($strLongUrl);
	
	//Insert what was posted from last form.
	$sql = "INSERT INTO Bases (baseName, basePassword, baseScanPoints, baseTrivia, baseAnswer, shortURL, lat, longitude)
	VALUES('$_POST[baseName]','$_POST[basePassword]','$_POST[baseScanPoints]','$_POST[baseTrivia]','$_POST[baseAnswer]','$strShortUrl','$_POST[lat]','$_POST[long]')";
	
	if (!mysql_query($sql,$con))
	  {
	  die('Error: ' . mysql_error());
	  }
	echo "Successfully added base " . $_POST[teamName];
	
	mysql_close($con);
	
	echo "<br /><img src=\"images/mrbean.jpg\">";
	echo "<br />Emile says hi, Matt.";
	
	echo "<br /><a href=\"../addBases.php\">Back to work, fool. Add some more bases.</a>";
?>
</body>
</html>