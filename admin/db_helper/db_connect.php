<?php

/* The database connections - required for each page */

	$con = mysql_connect("localhost","xitanto_uc2011","3f8923hfsjkljaJKJ");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
  	mysql_select_db("xitanto_urbanchallenge2011", $con);

?>