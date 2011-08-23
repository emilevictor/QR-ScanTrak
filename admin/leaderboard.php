<?php
	//Attempt connection to UC2011 database
	include("db_helper/db_connect.php");
	
	$place = 1;
	
	$result = $conn->query("SELECT * FROM Teams ORDER BY totalScore DESC");
	
	echo "<table border=\"0\" width=\"50%\">
  	<tr>
  	<th align=\"left\">Placement</th>
  	<th align=\"left\">Team number</th>
  	<th align=\"left\">Team name</th>
  	<th align=\"left\">Team Score</th>
  	</tr>";
  	
  	foreach($result->fetchAll(PDO::FETCH_OBJ) as $row) {
  		echo "<tr onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">";
  		echo "<td bgcolor=\"white\" color=\"black\" align=\"center\"><b>" . $place . "</b></td>";
  		$place++;
  		echo "<td>" . $row->teamNum . "</td>";
  		echo "<td>" . $row->teamName . "</td>";
  		echo "<td>" . $row->totalScore . "</td>";
  		echo "</tr>";
  	}
  	echo "</table>";
	
	mysql_close($con);
?>