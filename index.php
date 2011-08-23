<?php 
	/* QR Scan Tracker (QRST)
	 * @author by Emile Victor
	 * Originally written for Scouts Queensland, Urban Challenge 2011.
	 * Utilises PHP, Javascript and MySQL.
	 * This script is free to distribute, and use for non-commercial
	 * purposes. For commercial use, please contact the author
	 * via email (e@mediahug.com). Donations are also appreciated:
	 * paypal: emilevictor@gmail.com
	 * 
	 * Please contact me if you are using this script - I am always
	 * interested to know how this work is being used. I am currently
	 * a student, so feedback (and money!) is appreciated.
	 * 
	 * Address: http://www.mediahug.com/
	 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="fb:admins" content="675777149,744607803,513944349,565612028"/>
<title>Urban Challenge Check-in System</title>
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
</style></head>

<body>

<?php
	/* Get password from URL */
	$val = $_GET['q'];
	
	if ($_GET['success'] == "epicfail") {
		echo "<h2>Epic fail: Fat man is not amused. Your trivia answer was WRONG!</h2>";
		echo "<img src=\"images/safeduck.jpg\"><br /><br />";
	}
	
	
	/******* DATABASE CONNECTION ********/
	
	include("admin/db_helper/db_connect.php");
	
  	
	/*Check the referrer is a QR Code*/
	$google = "g";
	$wwwgoogle = "www.goo.gl";
	$referer = $_SERVER['HTTP_REFERER'];
	
	if ($referer == "") { // Check that the referer is actually sent.
		$domain = $google;
	} else {
		$domain = parse_url($referer); //Parse the URL otherwise
	}
	
	$stmt = $conn->prepare('SELECT * FROM Bases WHERE basePassword=:pass LIMIT 1');
	$stmt->bindValue(':pass', $val);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	
	//if ($domain['host'] == $google || $domain['host'] == $wwwgoogle) {
			/*Make the array for all of the activity bases*/
	if ($row->baseScanPoints != NULL) {
		echo "<img src=\"images/UCLogoInverted.jpg\"><br />";
		echo "<h1>Welcome to ".$row->baseName."</h1>";
		echo "<form action=\"addPoints.php\" method=\"post\">";
		echo "ID Number: <input type=\"text\" name=\"tNum\" /><br />";
		echo "Team Password: <input type=\"password\" name=\"pwd\" /><br />";
		$boolRequireTrivia = 0;
		if ($row->baseTrivia != "!") {
			echo "You can only submit a trivia-based QR code ONCE. Make sure that your answer is correct before submission!!<br />";
			echo "Trivia Question: ".$row->baseTrivia;
			echo "<br />";
			echo "What number is the answer? (type answer like \"1\", not \"one\") <input type=\"text\" name=\"triviaAnswer\" />";
			$boolRequireTrivia = 1;
		}
		echo "<input type=\"hidden\" name=\"baseEasyName\" value=\"".$row->baseEasyName."\">";
		echo "<input type=\"hidden\" name=\"baseID\" value=\"".$row->baseID."\">";
		echo "<input type=\"hidden\" name=\"basePassword\" value=\"".$row->basePassword."\">";
		echo "<input type=\"hidden\" name=\"boolRequireTrivia\" value=\"".$boolRequireTrivia."\">";
		echo "<br /><input type=\"submit\" />";
		echo "</form>";
		echo "<br />";
		echo "<a href=\"checkPoints.php\"><img src=\"images\pointsBalance.png\"></a><br />";
		echo "<h1>Leave messages here:</h1><br /><div id=\"fb-root\"></div><script src=\"http://connect.facebook.net/en_US/all.js#xfbml=1\"></script><fb:comments href=\"http://www.urbanchallenge.com.au/index.php\" num_posts=\"5\" width=\"500\" colorscheme=\"dark\"></fb:comments>";
		echo "<br /><a href=\"http://www.qldrovers.org.au/\"><img src=\"images/QLDRovers.jpg\"></a>&nbsp;<a href=\"http://www.scoutsqld.com.au/\"><img src=\"images/ScoutsQLD.jpg\"></a>
		<p><small>System written in PHP by <a href=\"http://www.facebook.com/pages/St-Johns-Wood-Rover-Crew/141056449255004\">St John's Wood Rover</a> Emile Victor.</small></p>";
		//addPoints($points[$bases[$val]]); /*Removed due to addPoints.php file existing*/
	} else {
		//echo "<img src=\"images/UCLogoInverted.jpg\"><br /><h1>Welcome to UC2011's Code Portal.</h1><p>This is where you will be redirected when you scan a QR code during the course of the challenge. <br />Instead of seeing this page, you will be presented with a login form, <br />where you can put your team's username and password in. <br />Your points will be automatically added to your total.<br /><br />
		//Advanced anti-cheating protection is enabled, so please, if you find a way to cheat,<br /> don't try. It's a honeypot, and we will deduct some serious points from you for it.</p>
		//";
		echo "<img src=\"images/UCLogoInverted.jpg\"><br />";
		echo "<h2>Welcome to Urban Challenge 2011</h2>";
		echo "<p>This is the page you will use to input your codes if you do not have a phone,<br /> or to check your points balance.</p>";
		echo "<a href=\"checkPoints.php\"><img src=\"images\pointsBalance.png\"></a><br />";
		echo "<a href=\"noPhoneInput.php\"><img src=\"images\codeInput.png\"></a><br />";
		//echo "<a href=\"http://www.urbanchallenge.com.au/application/\"><img src=\"images\applyHere.png\"></a><br /><br />";
		echo "<h1>Leave messages here:</h1><br /><div id=\"fb-root\"></div><script src=\"http://connect.facebook.net/en_US/all.js#xfbml=1\"></script><fb:comments href=\"http://www.urbanchallenge.com.au/index.php\" num_posts=\"5\" width=\"500\" colorscheme=\"dark\"></fb:comments>";
		echo "<br /><a href=\"http://www.qldrovers.org.au/\"><img src=\"images/QLDRovers.jpg\"></a>&nbsp;<a href=\"http://www.scoutsqld.com.au/\"><img src=\"images/ScoutsQLD.jpg\"></a>
		<p><small>System written in PHP by <a href=\"http://www.facebook.com/pages/St-Johns-Wood-Rover-Crew/141056449255004\">St John's Wood Rover</a> Emile Victor.</small></p>";
	}
	//} else {
	//	echo "<h1>You did not access this page from a QR Code. You may be cheating. </h1>";
	//}

?>
</body>
</html>