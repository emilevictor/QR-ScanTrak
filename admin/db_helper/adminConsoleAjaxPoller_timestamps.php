<?php
	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	$sql = "SELECT * FROM Timestamps ORDER BY timestamp DESC LIMIT 30";
	
	$result = mysql_query($sql);
	
	echo "<table border=\"0\" width=\"100%\">
	<tr>
	  <th align=\"left\">Team number</th>
	  <th align=\"left\">QR/Base/Source of Point Change</th>
	  <th align=\"left\">Time</th>
	  <th align=\"left\">Points scanned</th>
	  <th align=\"left\">Comment</th>
  	</tr>";
	
	while($row = mysql_fetch_array($result)) {
	  	echo "<tr onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">";
	  	echo "<td>" . $row['teamNum'] . "</td>";
	  	if ($row['baseID'] == NULL) {
	  		echo "<td>Point Modification</td>";
	  	} else {
	  		echo "<td>" . $row['baseID'] . "</td>";
	  	}
	  	echo "<td>" . $row['timestamp'] . "</td>";
	  	echo "<td>" . $row['baseScanPoints'] . "</td>";
	  	echo "<td>" . $row['comment'] . "</td>";
	 	echo "</tr>";
	}
	echo "</table>";
	
	mysql_close($con);
?>