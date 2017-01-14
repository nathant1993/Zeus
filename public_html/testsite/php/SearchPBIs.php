<?php
  
  //PHP file to search for PBIs based on values in drop down filter boxes
  
  // Connecting to the MySQL server
  $host="10.168.1.92";
  $user_name="wearezeu_phpserv";
  $pwd="0!ZeusPhP!0";
  $dbName="wearezeu_test01";
    
  // Create connection
  $conn = new mysqli($host, $user_name, $pwd, $dbName);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 

  // Storing form values into PHP variables
  $project = $_POST["postedProject"];
  $sprint = $_POST["postedSprint"];
  $priority = $_POST["postedPriority"];
  $state = $_POST["postedState"];
  
  
  //Check if the incoming variables are equal to 'Any' or are empty and form their respective sql where clauses appropriately
  if ($project == 'Any' || empty($project)){
    $projectWhere =  " like '%'";
  }
  else{
    $projectWhere = " = (select project_id from project where project_name = '$project')";
  }
  
   if ($sprint == 'Any' || empty($sprint)){
     $sprintWhere = " like '%'";
   }
   else{
     $sprintWhere = " = (select iteration_id from iteration where iteration_name = '$sprint')";
   }
  
   if ($priority == 'Any' || empty($priority)){
     $priorityWhere = " like '%'";
   }
   else{
     $priorityWhere = " = (select priority_id from priority where description = '$priority')";
   }
   
   if ($state == 'Any' || empty($state)){
     $stateWhere = " like '%'";
   }
   else{
     $stateWhere = " = (select state_id from states where state_name = '$state' and state_type = 'PBI')";
   }
   
   //dynamic query based on the sql statements formed above that allow for Null entries and 'Any'entries   
   $query = 
     "Select pbi_id, 
             pbi_title 
       from backlog_items 
       where project_id".$projectWhere."
       And iteration_id".$sprintWhere."
       And priority_id".$priorityWhere."
       And state_id".$stateWhere;    
    
  //Run the query or exit neatly with an error code
  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");

  //Put the query results into an array and pass it to the JavaScript
	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$shortPBIData[] = array(
			'pbiId' => $row['pbi_id'],
			'pbiTitle' => $row['pbi_title'],
		  );
	}

	echo json_encode($shortPBIData);

  $conn->close();

?>

