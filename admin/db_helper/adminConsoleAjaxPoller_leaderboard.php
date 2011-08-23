<?php
	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	$sql = "SELECT * FROM Teams ORDER BY totalScore DESC LIMIT 25";
	$place = 1;
	
	$result = mysql_query($sql);
	
	echo "<table border=\"0\" width=\"50%\">
  	<tr>
  	<th align=\"left\">Placement</th>
  	<th align=\"left\">Team number</th>
  	<th align=\"left\">Team name</th>
  	<th align=\"left\">Team Score</th>
  	</tr>";
  	
  	while($row = mysql_fetch_array($result)) {
  		echo "<tr onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">";
  		echo "<td bgcolor=\"black\" color=\"white\" align=\"center\"><b>" . $place . "</b></td>";
  		$place++;
  		echo "<td>" . $row['teamNum'] . "</td>";
  		echo "<td>" . $row['teamName'] . "</td>";
  		echo "<td>" . $row['totalScore'] . "</td>";
  		echo "</tr>";
  	}
  	echo "</table>";
	
	mysql_close($con);
?>