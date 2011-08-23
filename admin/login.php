<html>

<head>
<title>UC2011: Login</title>

<style type="text/css">
<!--
body,td,th {
	color: #FFF;
}
body {
	background-color: #000;
}

.redtext {
	color:#F00;
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
<center><p><img src="../images/UCLogoInverted.jpg"></p>
<h1>Log in</h1>
<?php 
	$success = $_GET['success'];
	if ($success == 'wrongcredentials') {
		echo "<p class=\"redtext\">Username/Password combination was wrong.</p>";
	}
?>
<form action="db_helper/authenticate.php" method="post">
Username: <input type="text" name="username" /><br />
Password: <input type="password" name="password" /><br />
<input type="submit" value="LOG IN"/>
</form></center>
<br />

</body>
</html>