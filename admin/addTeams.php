<?php 
	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>

<head>
<title>UC2011 Team Adder</title>
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
<a href="index.php"> <- Back to admin</a>
<p><img src="../images/UCLogoInverted.jpg"></p>
<h1>Add/Edit UC2011 teams</h1>

<form action="db_helper/teamInsert.php" method="post">
Team Name: <input type="text" name="teamName" /><br />
Password (for QR Codes): <input type="text" name="password" /><br />
Emergency Contacts: <input type="text" name="emergencyPhones" /><br />
<input type="submit" value="Add Team"/>
</form>

<?php 
	//Database connection
	include_once("db_helper/db_connect.php");
  	
  	echo "<h3>Current Teams</h3><br />";
  	
  	$result = $conn->query("SELECT * FROM Teams");
  	
  	echo "<table border=\"0\" width=\"800px\">
  	<tr>
  	<th align=\"left\">Team number</th>
  	<th align=\"left\">Team name</th>
  	<th align=\"left\">Password</th>
  	<th align=\"left\">Emergency Contacts</th>
  	</tr>";
  	
  	foreach($result->fetchAll(PDO::FETCH_OBJ) as $row) {
  		echo "<tr onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">";
  		echo "<td>" . $row->teamNum . "</td>";
  		echo "<td>" . $row->teamName . "</td>";
  		echo "<td>" . $row->password . "</td>";
  		echo "<td>" . $row->emergencyPhone . "</td>";
  		echo "<td><a href=\"editTeams.php?teamNum=" . $row->teamNum . "\">EDIT</a></td>";
  		echo "<td><a href=\"db_helper/teamDelete.php?teamNum=". $row->teamNum . "\">DELETE</a></td>";
  		echo "</tr>";
  	}
  	echo "</table>";
?>
<br />
<a href="index.php"> <- Back to admin</a>
</body>
</html>