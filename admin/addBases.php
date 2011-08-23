<?php 
	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>

<head>
<title>UC2011 QR Code Adder</title>

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

h2#notice {
	color:orange;
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
<h1>Add/Edit UC2011 QR Codes</h1>
<script> 
function randomPassword()
{
	chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	pass = "";
 
	for(x=0;x<11;x++)
	{
		i = Math.floor(Math.random() * 62);
		pass += chars.charAt(i);
	}
	
	return pass;
}
 
function formSubmit()
{
	insertForm.basePassword.value = randomPassword();
}
</script> 

<form action="db_helper/baseInsert.php" name="insertForm" method="post">
QR Code Name: <input type="text" name="baseName" /><br />
Password (for QR Codes): <input type="text" name="basePassword" /><input type="button" value="Generate" onClick="javascript:formSubmit()" tabindex="2"><br />
Scan Points (points earned when scanned): <input type="text" name="baseScanPoints" /><br />
QR Code trivia (<strong>use ! if you don't want to ask any trivia</strong>): <br />
<textarea rows="5" cols="100" name="baseTrivia" placeholder="Example: What is the colour of the fence you are looking at? 1. Brown, 2. Blue, 3. Red, 4. Grey"></textarea><br />
Multi-choice answer (1,2,3,4?): <input type="text" name="baseAnswer" /><br />
Latitude (decimal): <input type="text" name="lat" /><br />
Longitude (decimal): <input type="text" name="long" /><br />
<input type="submit" value="Add Base"/>
</form>

<script type="text/javascript" language="JavaScript">
    insertForm.basePassword.value = randomPassword();
</script>

<?php 
	$edited = $_GET['edited'];
	if ($edited == "yes") {
		echo "<h2 id=\"notice\">Base successfully edited</h2>";
	}
	// Database connection
	include_once("db_helper/db_connect.php");
  	
  	echo "<h3>Current Bases:</h3>";
  	
  	$result = $conn->query("SELECT * FROM Bases");
  	
  	echo "<table border=\"0\" width=\"100%\">
  	<tr>
  	<th align=\"left\">Base Number</th>
  	<th align=\"left\">Base Name</th>
  	<th align=\"left\">Password</th>
  	<th align=\"left\">Scan Points</th>
  	<th align=\"left\">Base Trivia</th>
  	<th align=\"left\">Trivia Answer</th>
  	<th align=\"left\">QR Code</th>
  	</tr>";
  	
  	foreach($result->fetchAll(PDO::FETCH_OBJ) as $row) {
  		echo "<tr onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">";
  		echo "<td>" . $row->baseID . "</td>";
      echo "<td>" . $row->baseName . "</td>";
  		echo "<td>" . $row->basePassword . "</td>";
  		echo "<td>" . $row->baseScanPoints . "</td>";
  		echo "<td>" . $row->baseTrivia . "</td>";
  		echo "<td>" . $row->baseAnswer . "</td>";
  		echo "<td><a href=\"" . $row->shortURL . ".qr\">QR CODE</a></td>";
  		echo "<td><a href=\"editBases.php?baseNum=" . $row->baseID . "\">EDIT</a></td>";
  		echo "<td><a href=\"db_helper/baseDelete.php?baseNum=". $row->baseID . "\">DELETE</a></td>";
  		echo "</tr>";
  	}
  	echo "</table>";
  	
  	echo "<br /><h3><a href=\"QR_print.php\">Click here for printable QR Codes</a></h3>";
?>
<br />
<a href="index.php"> <- Back to admin</a>

</body>
</html>