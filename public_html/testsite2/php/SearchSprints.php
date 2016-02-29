<?php
  // Connecting to the MySQL server
  // $host="10.168.1.92";
  // $user_name="wearezeu_phpserv";
  // $pwd="0!ZeusPhP!0";
  // $dbName="wearezeu_test01";

  include('DatabaseCon.php');
  
  //Start session
  session_start();
    
  // Create connection
  $conn = new mysqli($host, $user_name, $pwd, $dbName);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 
  
  $SprintNo = $_POST["postedSprintNoFromURL"];
  //$SprintNo = 'Sprint 18';
  //echo $SprintNo;
  $SprintsQuery = "SELECT CONCAT_WS(' - ',e.project_name, b.iteration_name) 'itName', b.iteration_start_date 'itStart', b.iteration_end_date 'itEnd', b.iteration_ID 'itID'
            FROM  iteration b
            inner join releases a on a.release_id = b.release_id
            inner join project e on e.project_id = b.project_id 
            where b.project_id = '".$_SESSION['SESS_PROJECT_ID']."'
            ORDER BY b.iteration_ID";

  $SprintResult = $conn->query($SprintsQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($SprintResult, MYSQL_ASSOC)) {
		$SprintsArray[] = array(
		//$row
      'itName' => $row['itName'],
      'itStart' => $row['itStart'],
      'itEnd' => $row['itEnd'],
      'itStartReadable' => date('d-m-Y',strtotime($row['itStart'])),
      'itEndReadable' => date('d-m-Y',strtotime($row['itEnd'])),
      'itID' => $row['itID']
		  );
	}
  
  if(empty($SprintNo)){
  $PbiQuery = "SELECT pbi_id, pbi_title
            FROM  backlog_items a
            right outer join iteration b on b.iteration_ID = a.iteration_ID
            where b.iteration_start_date <= DATE_FORMAT(sysdate(), '%Y-%m-%d') 
            and b.iteration_end_date >= DATE_FORMAT(sysdate(), '%Y-%m-%d')
            and a.project_id = '".$_SESSION['SESS_PROJECT_ID']."'
            ORDER BY a.pbi_id";
                    
  $PbiResult = $conn->query($PbiQuery) or exit("Error code ({$conn->errno}): {$conn->error}");
  }
  else{
    $PbiQuery = "SELECT pbi_id, pbi_title
            FROM  backlog_items a
            right outer join iteration b on b.iteration_ID = a.iteration_ID
            where iteration_name = '$SprintNo'
            and a.project_id = '".$_SESSION['SESS_PROJECT_ID']."'
            ORDER BY a.pbi_id";
                    
  $PbiResult = $conn->query($PbiQuery) or exit("Error code ({$conn->errno}): {$conn->error}");
  }
  
	while ($row = mysqli_fetch_array($PbiResult, MYSQL_ASSOC)) {
		$PbiArray[] = array(
		//$row
      'pbiId' => $row['pbi_id'],
      'pbiTitle' => $row['pbi_title']
		  );
	}          
  
  if(empty($SprintNo)){
  $TaskQuery = 
     "SELECT task_id, task_title, task_description, task_estimated_duration,task_hours_done, concat_ws(' ', f.user_forename, f.user_surname) 'assignee', concat('../images/',f.user_forename, f.user_surname,'.jpg') 'photoAddress', a.iteration_id 'itID', a.state_id 'stateID', d.state_name 'stateName', a.pbi_id 'pbiID', b.pbi_title 'pbiTitle', b.pbi_description 'pbiDescription', c.description 'priorityDesc'
        FROM task a
        inner join backlog_items b on b.pbi_id = a.pbi_id
        inner join priority c on c.priority_id = b.priority_id
        inner join states d on d.state_id = a.state_id
        inner join iteration e on e.iteration_id = a.iteration_id
        inner join users f on f.user_id = a.assignee
        where e.iteration_start_date <= DATE_FORMAT(sysdate(), '%Y-%m-%d') 
        and e.iteration_end_date >= DATE_FORMAT(sysdate(), '%Y-%m-%d')
        ORDER BY a.pbi_id";     
  
  $TaskResult = $conn->query($TaskQuery) or exit("Error code ({$conn->errno}): {$conn->error}");
  }
  else{
    $TaskQuery = 
     "SELECT task_id, task_title, task_description, task_estimated_duration,task_hours_done, concat_ws(' ', f.user_forename, f.user_surname) 'assignee', concat('../images/',f.user_forename, f.user_surname,'.jpg') 'photoAddress' , a.iteration_id 'itID', a.state_id 'stateID', d.state_name 'stateName', a.pbi_id 'pbiID', b.pbi_title 'pbiTitle', b.pbi_description 'pbiDescription', c.description 'priorityDesc', b.priority_id 'priorityId'
        FROM task a
        inner join backlog_items b on b.pbi_id = a.pbi_id
        inner join priority c on c.priority_id = b.priority_id
        inner join states d on d.state_id = a.state_id
        inner join iteration e on e.iteration_id = a.iteration_id
        inner join users f on f.user_id = a.assignee
        where e.iteration_name = '$SprintNo'
        ORDER BY a.pbi_id";     
  
  $TaskResult = $conn->query($TaskQuery) or exit("Error code ({$conn->errno}): {$conn->error}");
  }
  
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
      'photoAddress' => $row['photoAddress'],
      'stateID' => $row['stateID'],
      'stateName' => $row['stateName'],
      'pbiID' => $row['pbiID'],
      'pbiTitle' => $row['pbiTitle'],
      'pbiDesc' => $row['pbiDesc'],
      'priorityDesc' => $row['priorityDesc'],
      'priorityId' => $row['priorityId']
		  );
	}
  
	$AllResults[] = array ($SprintsArray, $PbiArray, $TaskDetails);
  
	echo json_encode($AllResults);

  $conn->close();
?>

