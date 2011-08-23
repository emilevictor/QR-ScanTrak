<?php 
	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>
<head>
<title>UC2011 Admin Console.</title>
<link href="css/styles.css" rel="stylesheet" type="text/css"  media="screen, projection"  /> 


<!-- AJAX table updaters -->
<script type="text/javascript">

function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  //var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  //currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;

  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}

	function executeBoth() {
		updateTimestampTable();
		updateLeaderboardTable();
		updateClock()
	}
	/******* Timestamp Table Updater *********/
	function updateTimestampTable() {
	
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				document.getElementById("timestampTable").innerHTML=xmlhttp.responseText;
			}
		}
		
		xmlhttp.open("GET","db_helper/adminConsoleAjaxPoller_timestamps.php",true);
		xmlhttp.send();
		
	}

	/******* Leaderboard Table Updater *********/
	function updateLeaderboardTable() {
	
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				document.getElementById("leaderboardTable").innerHTML=xmlhttp.responseText;
			}
		}
		
		xmlhttp.open("GET","db_helper/adminConsoleAjaxPoller_leaderboard.php",true);
		xmlhttp.send();
		
	}
	
	setInterval(executeBoth, 2000);
</script>

</head>

<body>

<p align="center"><img src="images/console_header.png"><br /><?php include("../VERSION.php"); ?><br /><strong>ROVERS: Please keep the leaderboard private from venturers until prizes are announced this afternoon. We want to keep the surprise.</strong></p>

<div class="wrapper">

	<div class="operations">
        <h2>
        <?php 
        	echo "Welcome, ";
        	if ($_SESSION['gender'] == "M") {
        		echo "Mr. " . $_SESSION['lastname'] . ".";
        	} else if ($_SESSION['lastname'] == "Oster") {
        		echo "YOUR ROYAL HIGHNESS, MISS OSTER.";
        	} else {
        		echo "Ms. " . $_SESSION['lastname'] . ".";
        	}
        ?>
          Current time is <span id="clock">&nbsp;</span></h2>
        <div id="nav-menu">
            <ul>
            <!-- <li><a href="addTeams.php">Add/Edit Teams</a></li> -->
            <!-- <li><a href="addBases.php">Add/Edit QR Codes</a></li> -->
            <li><a href="pleaseOrPunish.php">Please or Punish</a></li>
            <li><a href="timestamps_paginated.php">View/Search Scans</a></li>
            <li><a href="editNotice.php">Change HQ Notice to Teams</a></li>
            <li><a href="scanMap.html">The Scan Map</a></li>
            <li><a href="leaderboard.php">Show Printable Leaderboard</a></li>
            <li> <a href="logout.php">Logout</a></li>
            </ul>
         </div>
        
    </div>
    
    	<?php
	
			date_default_timezone_set('Australia/Brisbane');  	 	
			
			/********** LEADERBOARD ***********/
			
			echo "<div id=\"leaderboardTable\"><b>Loading the leaderboard...</b></div>";
			
			/********** MOST RECENT CHECK-INS ***********/
			
			//echo "<h2>Most recent check-ins.  </h2>";
			
			echo "<div id=\"timestampTable\"><b>Loading recent check-ins...</b></div>";

		?>
        



</div>

</body>

</html>