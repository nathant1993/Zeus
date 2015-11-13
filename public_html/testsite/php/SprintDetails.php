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
  $SprintID = $_POST["postedSprintID"];

  $TaskQuery = 
     "SELECT task_id, task_title, task_description, task_estimated_duration,task_hours_done, assignee, a.iteration_id 'itID', a.state_id 'stateID', d.state_name 'stateName', a.pbi_id 'pbiID', b.pbi_title 'pbiTitle', b.pbi_description 'pbiDescription', c.description 'priorityDesc'
        FROM task a
        inner join backlog_items b on b.pbi_id = a.pbi_id
        inner join priority c on c.priority_id = b.priority_id
        inner join states d on d.state_id = a.state_id
        where  a.iteration_id = '$SprintID'";     
  
  $TaskResult = $conn->query($TaskQuery) or exit("Error code ({$conn->errno}): {$conn->error}");
  
  while ($row = mysqli_fetch_array($TaskResult, MYSQL_ASSOC)) {
		$TaskDetails[] = array(
		//$row
			'taskId' => $row['task_id'],
			'taskTitle' => $row['task_title'],
      'taskDesc' => $row['task_description'],
      'taskEstimatedDuration' => $row['task_estimated_duration'],
      'taskHoursDone'=> $row['task_hours_done'],
      'itID' => $row['itID'],
      'assignee'  => $row['assignee'],
      'stateID' => $row['stateID'],
      'stateName' => $row['stateName'],
      'pbiID' => $row['pbiID'],
      'pbiTitle' => $row['pbiTitle'],
      'pbiDesc' => $row['pbiDesc'],
      'priorityDesc' => $row['priorityDesc']
		  );
	}
  
  $PbiQuery =
    "SELECT DISTINCT pbi_id, pbi_title
      FROM backlog_items b
      where iteration_id ='$SprintID'";
      
  $PbiResult = $conn->query($PbiQuery) or exit("Error code ({$conn->errno}): {$conn->error}");


	while ($row = mysqli_fetch_array($PbiResult, MYSQL_ASSOC)) {
		$PBI[] = array(
		//$row
			'pbiId' => $row['pbi_id'],
      'pbiTitle' => $row['pbi_title']
		  );
	}
  
  $AllResults[] = array ($TaskDetails, $PBI);
  
	echo json_encode($AllResults);

  $conn->close();

?>

