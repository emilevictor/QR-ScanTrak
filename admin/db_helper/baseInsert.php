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
	include("GooglPHP.php");
	//Include global settings
	include("../SETTINGS.php");

	//Attempt connection to UC2011 database
	$conn = include 'db_connect.php';
	
	// Create Goo.gl link
	//TODO: add option in some config file which will specify which URL to change this to.
	$strLongUrl = $_WEBSITE_ROOT_URL_ . "index.php?q=" . $_POST['basePassword'];
	echo $strLongUrl;
	$strShortUrl = GooglPHP::shortURL($strLongUrl);
	
	//Insert what was posted from last form.
	$stmt = $conn->prepare(
		'INSERT INTO Bases (baseName, basePassword, baseScanPoints, baseTrivia, baseAnswer, shortURL, lat, longitude)' .
		'VALUES(:name, :pass, :pts, :trivia, :answer, :url, :lat, :lat)'
	);
	$stmt->bindValue(':name',   $_POST['baseName']);
	$stmt->bindValue(':pass',   $_POST['basePassword']);
	$stmt->bindValue(':pts',    $_POST['baseScanPoints']);
	$stmt->bindValue(':trivia', $_POST['baseTrivia']);
	$stmt->bindValue(':answer', $_POST['baseAnswer']);
	$stmt->bindValue(':url',    $strShortUrl);
	$stmt->bindValue(':lat',    $_POST['lat']);
	$stmt->bindValue(':long',   $_POST['long']);
	
	if (!$stmt->execute()) {
		$err = $stmt->errorInfo();
		die('Error: ' . $err[2]);
	}
	echo "Successfully added base " . $_POST['teamName'];
	
	echo "<br /><img src=\"images/mrbean.jpg\">";
	echo "<br />Emile says hi, Matt." . $strShortUrl;
	
	echo "<br /><a href=\"../addBases.php\">Back to work, fool. Add some more bases.</a>";
?>
</body>
</html>
