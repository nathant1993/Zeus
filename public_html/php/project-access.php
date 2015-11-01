<?php

require_once('config.php');

//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db)
	{
		die("Unable to select database");
	}
	
	//Query to gain projects that the user is a member of
	$query = "SELECT project_id FROM users_projects WHERE user_id = '".$_SESSION['SESS_MEMBER_ID']."'";
	
	$result = mysql_query($query);
	
	//Project set to false originally
	$has_project = false;
	
	//If the user is a member of the project then flag the project as true
	if($result) {
		if(mysql_num_rows($result) > 0) 
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if ($row['project_id'] == $project)
				{
					$has_project = true;
				}
			}
			//If user is not a member of the project then redirect them to the access denied page
			if ($has_project != true)
			{
				header("location: access-denied.php");
			}
		}
		else {
			
			header("location: access-denied.php");
			exit();
		}
	}
	else {
		die("Query failed");
	}
	
	?>