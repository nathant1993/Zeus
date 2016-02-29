<?php
  
  //PHP file to create a Task
  
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
  
  //Check for a Null task title coming from the front end and throw and error 
  if($taskTitle == null || $taskTitle == ""){ 
    exit("Error: PBI Title is null or empty");
  }
  else{
  //Query to insert new task into task table
    $query = 
      "Insert into task
      (task_title, task_description, task_estimated_duration, task_hours_done,
      state_id, iteration_id, project_id, pbi_id, assignee)
      values
      ('$taskTitle', 
      '$taskDesc', 
      '$estTime',
      '$timeSpent', 
      (select state_id from states where state_name = '$pbiState' and state_type = 'Task'),
      (select iteration_id from iteration where iteration_name = '$pbiIteration'),
      (select project_id from project where project_name = '$pbiProject'),
      (select pbi_id from backlog_items where pbi_title = '$pbiTitle'),
      (select user_id from users where concat_ws(' ', user_forename, user_surname) = '$assignee')
      )";

    
    //Run the query
    if ($conn->query($query) === TRUE) {
     //Query to insert the new data into the audit table
      $query2 =  "INSERT INTO task_audit2 (time, email_address, action, task_id, new_title, new_description, new_estimated_duration, new_hours_done, new_assignee, new_state, new_iteration, new_pbi, new_project)
      VALUES (now(), '{$_SESSION['SESS_EMAIL_ADD']}', 'Insert', (select task_id from task where task_title = '$taskTitle'), '$taskTitle', 
      '$taskDesc', 
      '$estTime', '$timeSpent',
	  (select user_id from test_user where concat_ws(' ', user_forename, user_surname) = '$assignee'),
      (select state_id from states where state_name = '$pbiState' and state_type = 'Task'),
      (select iteration_id from iteration where iteration_name = '$pbiIteration'),
      (select pbi_id from backlog_items where pbi_title = '$pbiTitle'),
      (select project_id from project where project_name = '$pbiProject'))";
     
      if ($conn->query($query2) === TRUE) {
        //successfully added to audit table
      //  $_SESSION["action_result"] = "success";
      } else {
        //Failed to add to audit table
      //   $_SESSION["action_result"] = "failed";
      }
        // echo "PBI Updated successfully";
    } else {
       //  echo "Error: " . $query . "<br>" . $conn->error;
    }
  }
  $conn->close();
?>

