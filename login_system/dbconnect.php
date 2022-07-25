<!-- Author: Kamoy Saunders
	ID 20202957
	Date: 4/21/22
	Purpose: Major Project Internet Authoring 2
-->

<?php

	//store credentials in variables
	$dbServer = 'localhost';
	$dbUsername = 'root';
	$dbPswd = '';

	//Create connection to database
	$mp_conn = mysqli_connect($dbServer, $dbUsername, $dbPswd);
	if (!$mp_conn) {
		die("mp_connection failed: " . mysqli_connect_error());
	}
	else {

		//Create Database major_project
		$createDBquery = "CREATE DATABASE IF NOT EXISTS major_project" ;
		if (!mysqli_query($mp_conn, $createDBquery)) {
			echo "Error creating database: " . mysqli_error($mp_conn);
		}

		//Select Database major_project
		$dBselected = mysqli_select_db($mp_conn, "major_project" );
		if (!$dBselected) {
			echo "Error selecting database: " . mysqli_error($mp_conn);
		}

		//Create a table called Users if it does not exist
		$createTabquery = "CREATE TABLE IF NOT EXISTS major_project.users 
						(`Username` VARCHAR(100) NOT NULL , 
						`Password` VARCHAR(40) NOT NULL , 
						`Phone` VARCHAR(13) NOT NULL , 
						`Email` VARCHAR(50) NOT NULL , 
						UNIQUE `usn` (`Username`(100))) 
						ENGINE = InnoDB ";
		//Phone was set to VARCHAR(13) instead of VARCHAR(10) because the last 2 digits were being deleted by the database
		$createTable = mysqli_query($mp_conn, $createTabquery);
		if (!$createTable) {
			echo "Error creating table: " . mysqli_error($mp_conn);
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

</body>
</html>