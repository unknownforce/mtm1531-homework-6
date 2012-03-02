<?php
	
	//Gets an environment variable we created in the .htaccess file
	//This is the best way to keep username and passwords out of public GitHub repos
	$user = getenv('DB_USER'); // echo $user; // Check if it works
	$pass = getenv('DB_PASS');
	$dsn = getenv('DB_DSN');
	
	// Opens a connection to the database and stores it in a variable
	$db = new PDO($dsn, $user, $pass);
	// Makes sure we talk to the database in UTF-8, so we can support more than just English
	$db->exec('SET NAMES utf8');