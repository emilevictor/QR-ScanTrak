<?php 
	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>

<head>
<title>UC2011 QR print</title>

<style type="text/css">
<!--
body,td,th {
	color: #000;
}
body {
	background-color: #FFF;
	font-family:"Verdana";
}
#label {
	width:755px;
	background-image:url('images/QR_Label_background.png');
	background-repeat: none;
	height:247px;
	border-width:medium;
	border-style:double;
	border-color:black;
	margin-bottom:20px;
}

img.qr {
	position:relative;
	left:580px;
	top:27px;
}

p.baseID {
	position:relative;
	left:280px;
	top:170px;
}

p.baseName {
	position:relative;
	left:-190px;
	top:95px;
}

p.basePassword {
	position:relative;
	left:0px;
	top:23px;
}

p.page {
	page-break-before: always;
}

#labelInner {
	margin:auto;
}

#labelText {
	position:relative;
	left:350px;
	top: -140px;
}
  
-->
</style>
</head>
<body>

<?php 
	//Connect to DB
	include("db_helper/db_connect.php");
  	
  	$result = mysql_query("SELECT * FROM Bases");
  	
  	$count = 1;
  	
  	while ($row = mysql_fetch_array($result)) {
  		
  		echo "<div id=\"label\">";
  		echo "<div id=\"labelInner\">";
	  		echo "<img class=\"qr\" src=\"" . $row['shortURL'] . ".qr\">";
		  		echo "<div id=\"labelText\">";
		  		echo "<p class=\"baseID\">" . $row['baseID'] . "</p><br />";
		    	echo "<p class=\"baseName\">" . $row['baseName'] . "</p><br />";
		    	echo "<p class=\"basePassword\">" . $row['basePassword'] . "</p><br />";
		    	echo "</div>";
	    	echo "</div>";
  		echo "</div>";
  		if ($count == 4) {
  			echo "<p class=\"page\"></p>";
  			$count = 1;
  		} else {
  			$count++;
  		}
  	}
  	
  	echo "<br />";
  	
  	/*
  	
  	
  	echo "<table border=\"0\" width=\"100%\">";
  	
  	$i = 1;
  	
//  	while($row = mysql_fetch_array($result)) {
//  		echo "<tr>";
//  		echo "<td><h3>" . $row['baseID'] . "</h3></td>";
//  		echo "<td><h3>" . $row['baseName'] . "</h3></td>";
//  		echo "<td><img src=\"" . $row['shortURL'] . ".qr\"></td>";
//  		echo "</tr>";
//  	}
//  	echo "</table>";

  	while ($row = mysql_fetch_array($result)) {
  		if ($i == 1) {
  			echo "<tr><td>".$row['baseID']."<br />".$row['baseName']."<br /><img src=\"" . $row['shortURL'] . ".qr\"><br /></td>";
  			$i++;
  		} else if ($i == 2) {
  			echo "<td>".$row['baseID']."<br />".$row['baseName']."<br /><img src=\"" . $row['shortURL'] . ".qr\"><br /></td></tr>";
  			$i--;
  		}
  	}
  	
  	if ($i == 2) {
  		echo "</tr></table>";
  	} else {
  		echo "</table>";
  	}*/
  	
  	mysql_close($con);
?>
<br />
<a href="index.php"> <- Back to admin</a>

</body>
</html>