<?php
  
  //PHP file to search for PBIs based on values in drop down filter boxes
  
  //Start session
  session_start();
  
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
  //$project = $_POST["postedProject"];
  $sprint = $_POST["postedSprint"];
  $state = $_POST["postedState"];
  
  
  //Check if the incoming variables are equal to 'Any' or are empty and form their respective sql where clauses appropriately
  // if ($project == 'Any' || empty($project)){
  //   $projectWhere =  " like '%'";
  // }
  // else{
  //   $projectWhere = " = (select project_id from project where project_name = '$project')";
  // }
  
   if ($sprint == 'Any' || empty($sprint)){
     $sprintWhere = " like '%'";
   }
   else{
     $sprintWhere = " = (select iteration_id from iteration where iteration_name = '$sprint')";
   }
   
   if ($state == 'Any' || empty($state)){
     $stateWhere = " like '%'";
   }
   else{
     $stateWhere = " = (select state_id from states where state_name = '$state' and state_type = 'Tasks')";
   }
   
   //dynamic query based on the sql statements formed above that allow for Null entries and 'Any'entries   
   $query = 
     "Select task_id, 
             task_title 
       from task 
       where project_id = '".$_SESSION['SESS_PROJECT_ID']."'
       And iteration_id".$sprintWhere."
       And state_id".$stateWhere;    
    
  //Run the query or exit neatly with an error code
  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");

  //Put the query results into an array and pass it to the JavaScript
	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$shortPBIData[] = array(
			'taskId' => $row['task_id'],
			'taskTitle' => $row['task_title'],
		  );
	}

	echo json_encode($shortPBIData);

  $conn->close();

?>

