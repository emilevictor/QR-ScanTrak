<html>

<head>
<title>Notice Edit</title>
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

	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	//Insert what was posted from last form.
	$sql = "UPDATE Notice
	SET title='".$_POST[title]."',body='".$_POST[body]."'
	WHERE noticeNum=1" or die(mysql_error());
	$stmt = $conn->prepare('UPDATE Notice SET title=:title, body=:body WHERE noticeNum=1');
	$stmt->bindValue(':title', $_POST['title']);
	$stmt->bindValue(':body',  $_POST['body']);
	
	if (!$stmt->execute()) {
		$err = $stmt->errorInfo();
		die('Error: ' . $err[2]);
	}
	echo "<img src=\"../images/Left-4-Dead-2.jpeg\"><br />";
	echo "Successfully edited HQ Notice";
	
	echo "<br /><a href=\"../index.php\">Back to the index.</a>";
?>

</body>
</html>