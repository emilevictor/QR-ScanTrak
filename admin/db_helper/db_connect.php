<?php

/* The database connections - required for each page */

	try {
		$conn = new PDO("mysql:host=localhost;dbname=xitanto_urbanchallenge2011", "xitanto_uc2011","3f8923hfsjkljaJKJ");
	}
	catch (Exception $e) {
		die('Could not connect: ' . $e->getMessage());
	}
?>