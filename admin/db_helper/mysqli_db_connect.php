<?php

	/* The database connections - required for each page */
  	$mysqli = new mysqli('localhost','xitanto_uc2011','3f8923hfsjkljaJKJ','xitanto_urbanchallenge2011');

  	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
?>