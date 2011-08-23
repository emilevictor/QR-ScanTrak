<?php

/*	notifyChecker:
	Run by either cron or an ajax script in an open browser window,
	this script checks for new scans on QR codes that are being watched
	by zombies.
	If it finds a QR code that has been scanned since it was last run,
	it emails the zombie's email address.*/

	include("db_connect.php");
	//date_default_timezone_set('Australia/Brisbane'); 
	require_once '3rdparty/twitter/twitteroauth.php';
	
	/*Twitter*/
	define("CONSUMER_KEY", "3ljjxcp64FI9MVtq16D1Pg");
	define("CONSUMER_SECRET", "9Flur0STvOTdIOZ8pRdxc9dTkd2cK6ZaVj2AgyJB3oM");
	define("OAUTH_TOKEN", "256944656-0JSEQMK1HMLFVfdVW6bF4MxTuZjpIckZlOgxNWOo");
	define("OAUTH_SECRET", "F86flcZY69DE6zbnbxXLWZchHWqdwZT5J6ntkylP4");
	 
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
	$content = $connection->get('account/verify_credentials');

	//Query for all notifications from notifications table.
	$stmt = $conn->prepare("SELECT * FROM Notifications");
	if (!$stmt->execute()) {
		$err = $stmt->errorInfo();
		die('Could not fetch notifications: ' . $err[2]);
	}
	$emailString = "";
	$twoMinsAgo = mktime(date("h")-8,date("i")-2,date("s"),date("m"),date("d")+1,date("Y"));
	//Loop through each notification email:base pair.
	foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $notificationArray) {
		$basesArray = explode(",", $notificationArray->bases);
		
		foreach($basesArray as $baseElement) {
			//echo $baseElement;
			$queryTimestamps = $conn->prepare("SELECT * FROM Timestamps WHERE baseID=:id ORDER BY actionID DESC");
			$queryTimestamps->bindValue(':id', (int) $baseElement);
			$queryTimestamps->execute();

			//Get latest occurance
			$queryTimestampsArray = $queryTimestamps->fetch(PDO::FETCH_OBJ);
			$phpDate = strtotime($queryTimestampsArray->timestamp);
			if ($phpDate > $twoMinsAgo) {
				//Appending operator .=
				$emailString .= $baseElement;
			}
			echo $emailString;
		}
		
		if ($emailString != "") {
			echo "Before tweet ";
			$connection->post('statuses/update', array('status' => "Zombie Checkin: ".$emailString." @".$notificationArray->email));
			echo "Tweeted";
			$emailString = "";
		}
		
	}

?>