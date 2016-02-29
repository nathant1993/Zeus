<?php

require_once('config.php');

//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	$query = "select project_id from users_projects where user_id = '".$_SESSION['SESS_MEMBER_ID']."'";
	
	$result = mysql_query($query);
	
	$has_project = false;
	
	if($result) {
		if(mysql_num_rows($result) > 0) {
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if ($row['project_id'] == $project)
				{
					$has_project = true;
				}
			}
			if ($has_project != true)
			{
				header("location: access-denied.php");
			}
		}
		else {
			//Login failed
			header("location: access-denied.php");
			exit();
		}
	}else {
		die("Query failed");
	}
	
	?>