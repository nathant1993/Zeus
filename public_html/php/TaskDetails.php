<?php
  // Connecting to the MySQL server
//   $host="10.168.1.92";
//   $user_name="wearezeu_phpserv";
//   $pwd="0!ZeusPhP!0";
//   $dbName="wearezeu_test01";

  include('DatabaseCon.php');
    
  // Create connection
  $conn = new mysqli($host, $user_name, $pwd, $dbName);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 

  // Storing form values into PHP variables
  $TaskID = $_POST["postedTaskID"];

  $query = 
     "SELECT task_id, task_title, task_description, task_estimated_duration, task_hours_done, 
     concat_ws(' ', c.user_forename, c.user_surname) 'assignee', d.state_name 'state', b.iteration_name 'itName', 
     f.pbi_title 'pbi_title'
            FROM  task a
            left outer join iteration b on b.iteration_ID = a.iteration_ID
            left outer join users c on c.user_id = a.assignee
            left outer join states d on d.state_id = a.state_id
            left outer join project e on e.project_id = a.project_id
            left outer join backlog_items f on f.pbi_id = a.pbi_id 
            where  task_id = '$TaskID'";     
  
  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$PBIDetails[] = array(
			'taskId' => $row['task_id'],
			'taskTitle' => $row['task_title'],
      'taskDesc' => $row['task_description'],
      'taskEstTime' => $row['task_estimated_duration'],
      'taskHoursDone'=> $row['task_hours_done'],
      'assignee' => $row['assignee'],
      'state' => $row['state'],
      'itName' => $row['itName'],
      'pbiTitle' => $row['pbi_title']
		  );
	}

	echo json_encode($PBIDetails);

  $conn->close();

?>

