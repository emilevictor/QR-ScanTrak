<?php

	/* QR Scan Tracker (QRST)
	 * @author by Emile Victor
	 * Originally for Scouts Queensland, Urban Challenge 2011.
	 * Utilises PHP, Javascript and MySQL.
	 * This script is free to distribute, and use for non-commercial
	 * purposes. For commercial use, please contact the author
	 * via email (e@mediahug.com). Donations are also appreciated:
	 * paypal: emilevictor@gmail.com
	 * 
	 * Address: http://www.mediahug.com/
	 */

	/* Check for authentication, for this *is* an admin page */
	include("db_helper/checkForAuthentication.php");
	
	//Attempt connection to UC2011 database
	include("db_helper/db_connect.php");
	




	// Fuck. This. You can do it Emile. - rmccue




	/* Amount of elements per page */
	$perPage = 30;
	
	/* Give us some empty strings */
	$pageLinks = "";
	
	/* GET if there is data from a search */
	$teamNum = $_GET[teamNum];
	$baseID = $_GET[baseID];
	$comment = $_GET[comment];
	
	/*Construct the search text to be appended to query*/
	$searchText = "";
	if (($teamNum != "")||($baseID != "")||($comment != "")) {
		$searchText .= "WHERE ";
	}
	if ($teamNum != "") {
		$searchText .= "teamNum = '".$teamNum."' ";
	}
	
	
	if (($teamNum != "")&&($baseID != "")) {
		$searchText .= "AND ";
	} else if (($teamNum != "")&&($comment != "")) {
		$searchText .= "AND ";
	}
	
	if ($baseID != "") {
		$searchText .= "baseID = '".$baseID."' ";
	}
	
	if (($baseID != "")&&($comment != "")) {
		$searchText .= "AND ";
	}
	
	if ($comment != "") {
		$searchText .= "MATCH comment AGAINST ('".$comment."') ";
	}
	
	/* DEBUG: print the searchText for testing purposes. */
	//echo $searchText;
	
	/* Find element number to start at (ie page 3 = 3*30 elements = element 90 */
	$startPageAt = $_GET[page] * $perPage;
	
	/* Count the number of scans. This is used for the number of elements. */
	$query = mysql_query("select count(actionID) from Timestamps ".$searchText);
	$row = mysql_fetch_array($query);
	
	$pages = ($row[0] + $perPage - 1) / $perPage;
	
	
	/* Now query the database JUST for the fragment of elements shown on this page. */
	/* Also, if the searchText is not empty, add it where appropriate. */
	if ($searchText != "") {
		$query = mysql_query("select * from Timestamps ".$searchText."order by actionID desc limit $startPageAt,$perPage");
	} else {
		$query = mysql_query("select * from Timestamps order by actionID desc limit $startPageAt,$perPage");
	}
	
	?>


<!DOCTYPE a PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>UC2011 Scan Search & View</title>
<link href="css/styles.css" rel="stylesheet" type="text/css"  media="screen, projection"  /> 
</head>

<body>

<form action="db_helper/timestamps_paginated_query.php" method="post">
	Team Number (optional): <input type="text" name="teamNum" value="<?php echo $_GET[teamNum]; ?>"/><br />
	QR Code (optional): <input type="text" name="baseID" value="<?php echo $_GET[baseID]; ?>"/><br />
	Comment contains (optional): <input type="text" name="comment" value="<?php echo $_GET[comment]; ?>"/><br />
	<input type="submit" value="Search"/><br />
</form>

<?php 
	/*Pagination links*/
	for ($k=0; $k < $pages; $k++) {
        if ($k != $_GET[page]) {
         $pageLinks .= " <a href=$PHP_SELF"."?page=$k>".($k+1)."</a>";
        } else {
         $pageLinks .= " <b><u>".($k+1)."</u></b>";
        }
	}
	
	echo $pageLinks;
	
	echo "<div id=\"timestampTable\">";
	
	echo "<table border=\"0\" width=\"100%\">
	<tr>
	  <th align=\"left\">Team number</th>
	  <th align=\"left\">QR/Base/Source of Point Change</th>
	  <th align=\"left\">Time</th>
	  <th align=\"left\">Points scanned</th>
	  <th align=\"left\">Comment</th>
  	</tr>";
	
	while($row = mysql_fetch_array($query)) {
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
	echo "</div>";
	
	echo $pageLinks;
	mysql_close($con);
?>

</body>