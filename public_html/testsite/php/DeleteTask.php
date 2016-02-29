<?php
  
  //PHP file to create a PBI
  
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
  $taskId = $_POST["postedID"];
  $taskTitle = mysqli_escape_string($conn,$_POST["postedTitle"]);
  $pbiTitle = mysqli_escape_string($conn,$_POST["postedPbiTitle"]);
  $assignee = $_POST["postedAssignee"];
  $taskDesc = mysqli_escape_string($conn,$_POST["postedDesc"]);
  $estTime = $_POST["postedEstimatedTime"];
  $timeSpent = $_POST["postedTimeSpent"];
  $pbiState = $_POST["postedState"];
  $pbiIteration = $_POST["postedIteration"];
  $pbiProject = $_POST["postedProject"];  
  
  //Check for a Null pbiID coming from the front end and throw and error 
  if($taskId == null || $taskId == ""){ 
    exit("Error: PBI ID is null or empty");
  }
  else{
  //Query to update a PBI based on the ID of that PBI
    $query = 
      "INSERT INTO task_audit2 (time, email_address, action, task_id, old_title, old_description, old_estimated_duration, old_hours_done, old_assignee, old_state, old_iteration, old_pbi, old_project)
      VALUES (now(), '{$_SESSION['SESS_EMAIL_ADD']}', 'Delete', '$taskId', '$taskTitle', '$taskDesc', '$estTime', '$timeSpent', (select user_id from test_user where concat_ws(' ', user_forename, user_surname) = '$assignee'),
	  (select state_id from states where state_name = '$pbiState' and state_type = 'Task'),
      (select iteration_id from iteration where iteration_name = '$pbiIteration'),
	  (select pbi_id from backlog_items where pbi_title = '$pbiTitle'),
      (select project_id from project where project_name = '$pbiProject'))";
    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
    //     echo "PBI Updated successfully";
    } else {
    //     echo "Error: " . $query . "<br>" . $conn->error;
    }
    $query = 
      "DELETE FROM task where task_id = '$taskId'";
    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
    //     echo "PBI Updated successfully";
    } else {
    //     echo "Error: " . $query . "<br>" . $conn->error;
    }
  }
  $conn->close();
?>

