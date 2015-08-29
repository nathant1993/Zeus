<?php
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
  
  //  $project = 'Zeus';
  //  $sprint = 'Sprint 13';
  // $priority = 'Medium';
  // $state = 4;
  
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
    
  // if ($conn->query($query) === TRUE) {
  //     //echo "New record created successfully"
	//   //header("Location: http://www.wearezeus.co.uk/indexdev.html");
  // } else {
  //     //echo "Error: " . $query . "<br>" . $conn->error;
	//   //header("Location: http://www.wearezeus.co.uk/indexdev.html");
  // }
  
  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");


	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$shortPBIData[] = array(
		//$row
			'pbiId' => $row['pbi_id'],
			'pbiTitle' => $row['pbi_title'],
		  );
	}

	echo json_encode($shortPBIData);

  $conn->close();

?>

