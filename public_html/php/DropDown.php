<?php
  
  //PHP file to find the values needed to populate the drop down filter boxes
  
  // Connecting to the MySQL server
  $host="10.168.1.92";
  $user_name="wearezeu_phpserv";
  $pwd="0!ZeusPhP!0";
  $dbName="wearezeu_test01";
  
  //Start session
  session_start();
    
  // Create connection
  $conn = new mysqli($host, $user_name, $pwd, $dbName);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 
   
  //Query for return Project names
  // $projectQuery = 
  //   "Select project_name
  //     from project
  //     order by project_name";
  
  //Query for returning Sprints - commented query limits you to seeing the sprints that you are in or are in the past
  //This was removed so you can use Zeus to plan for the future.     
  $sprintQuery =
  "Select Iteration_name 
      from iteration 
      where Iteration_name <> 'Sprint 0'
      and project_id = '".$_SESSION['SESS_PROJECT_ID']."'
      Order by Iteration_id DESC"; 
  
  //Query to return the priorities in the database    
  $priorityQuery =
  "Select description
    from priority
    order by priority_id";
  
  //Query to return the States that are applicable to a PBI   
  $stateQuery =
  "Select state_name
    from states
    where state_type = 'PBI'
    order by state_id";
      
  //Query to return the PBI titles to power the live search in the creation form 
  $pbiTitleQuery =
   "SELECT pbi_title FROM `backlog_items` where project_id = '".$_SESSION['SESS_PROJECT_ID']."'";
   
  //Query to return the people tasks can be assigned to
  $assigneeQuery =
   "SELECT CONCAT_WS(' ', user_forename, user_surname) as assignee_name FROM `test_user`";         
  
  //Run the project query and iterate over each row, adding it to an array
  // $projectResult = $conn->query($projectQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	// while ($row = mysqli_fetch_array($projectResult, MYSQL_ASSOC)) {
	// 	$Projects[] = array(
	// 		'projectName' => $row['project_name']
	// 	  );
	// }
  
  //Run the sprint query and iterate over each row, adding it to an array
  $sprintResult = $conn->query($sprintQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($sprintResult, MYSQL_ASSOC)) {
		$Sprints[] = array(
			'IterationName' => $row['Iteration_name']
		  );
	}
  
  //Run the priority query and iterate over each row, adding it to an array
  $priorityResult = $conn->query($priorityQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($priorityResult, MYSQL_ASSOC)) {
		$Priority[] = array(
			'Priority' => $row['description']
		  );
	}

  //Run the state query and iterate over each row, adding it to an array
  $stateResult = $conn->query($stateQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($stateResult, MYSQL_ASSOC)) {
		$State[] = array(
			'State' => $row['state_name']
		  );
	}
  
  $pbiTitleResult = $conn->query($pbiTitleQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($pbiTitleResult, MYSQL_ASSOC)) {
		$pbiTitle[] = array(
			'pbiTitleResult' => $row['pbi_title']
		  );
	}
  
  $assigneeResult = $conn->query($assigneeQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($assigneeResult, MYSQL_ASSOC)) {
		$assignee[] = array(
			'assigneeResult' => $row['assignee_name']
		  );
	}

  //Combine all of the arrays generated above into one array to be passed to the JavaScript
  //$AllResults[] = array($Projects, $Sprints, $Priority, $State, $pbiTitle, $assignee);
  $AllResults[] = array($Sprints, $Priority, $State, $pbiTitle, $assignee);

	echo json_encode($AllResults);

  $conn->close();

?>

