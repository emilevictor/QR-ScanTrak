<?php 
	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>

<head>
<title>UC2011: PUNISH OR PLEASE</title>
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
-->
</style>
</head>
<body>
<a href="index.php"> <- Back to admin</a>
<h1>Please or Punish.</h1>
<p>Add/subtract points from teams.</p>

<form action="db_helper/pOrPExecute.php" method="post">
Team Number:<br /><input type="text" name="teamNum" placeholder="The team number"/><br />
Points (e.g. to subtract 300 points, enter -300. To add 300 points, enter 300.<br />
<input type="text" name="baseScanPoints" placeholder="e.g. 200 or -200"/><br />
Give a reason:<br />
<input type="text" name="comment" size="30" placeholder="Necessary for accountability"/><br />
<input type="submit" />
</form>

<br />
<a href="index.php"> <- Back to admin</a>
</body>
</html>