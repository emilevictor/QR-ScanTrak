<?php 
	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>
<head>
<title>Edit a Team</title>
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
<a href="addTeams.php"> <- Back</a>
<?php


	/******* Get the base number from URL *******/
	$teamNum = $_GET['teamNum'];
	
	/******* DATABASE CONNECTION ********/
	include("db_helper/db_connect.php");
	
	$result = $conn->prepare("SELECT * FROM Teams WHERE teamNum=:id");
	$result->bindValue(':id', $teamNum);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_OBJ);
	echo "<h1>Edit \"". $row->teamName."\"</h1>";
	
	/******** FORM FOR CURRENT FIELD DATA *********/
	
	echo "<form action=\"db_helper/teamEdit.php\" method=\"post\">";
	echo "Team Name: <input type=\"text\" name=\"teamName\" value=\"". $row->teamName ."\" /><br />";
	echo "Team Password: <input type=\"text\" name=\"pwd\" value=\"". $row->password ."\" /><br />";
	echo "Emergency Phone Numbers: <input type=\"text\" name=\"emergencyPhone\" value=\"". $row->emergencyPhone ."\" /><br />";
	echo "<input type=\"hidden\" name=\"teamNum\" value=\"".$teamNum."\">";
	echo "<br /><input type=\"submit\" value=\"Edit Team\"/>";
	echo "</form>";
	
?>
<a href="addTeams.php"> <- Back</a>
</body>
</html>