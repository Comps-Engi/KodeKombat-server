<?php

function engi_user() {
	require_once("constants.php");

	// 1. Create a database connection
	$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
	if (!$connection) {
			die("Database connection failed: " . mysql_error());
	}

	// 2. Select a database to use 
	$db_select = mysql_select_db(DB_NAME,$connection);

	if (!$db_select) {
			die("Database selection failed: " . mysql_error());
	}

	$user_query = sprintf("SELECT Email, `First Name`, `Second Name`, Active FROM users WHERE Email=%s",
		GetSQLValueString($loginUsername, "text"));
	$user = mysql_query($user_query, $connection) or die(mysql_error());
	$foundUser = mysql_num_rows($user);
	if ($foundUser) {

		$row = mysql_fetch_row($user);

		$result = array();

		$result['email'] = $row[0];
		$result['fullname'] = trim($row[1] . ' ' . $row[2]);
	} else {
		throw new Exception("User not found on the Engi site");
	}

	return $result;
}
