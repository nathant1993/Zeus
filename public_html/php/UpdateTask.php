<?php
  
  //PHP file to update PBI values
  
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
  if($taskTitle == null || $taskTitle == ""){ 
    exit("Error: PBI Title is null or empty");
  }
  else{
  //Query to update a PBI based on the ID of that PBI
    $query = 
      "update task
      SET task_title = '$taskTitle',
      task_description = '$taskDesc',
      task_estimated_duration = $estTime,
      task_hours_done = $timeSpent,
      assignee = (select user_id from users where concat_ws(' ', user_forename, user_surname) = '$assignee'),
      state_id = (select state_id from states where state_name = '$pbiState' and state_type = 'Tasks'),
      iteration_id = (select iteration_id from iteration where iteration_name = '$pbiIteration'),
      pbi_id = (select pbi_id from backlog_items where pbi_title = '$pbiTitle'),
      project_id = (select project_id from project where project_name = '$pbiProject')
      where task_id = '$taskId'";
    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
         echo "PBI Updated successfully";
    } else {
         echo "Error: ". "<br>" . $conn->error;
    }
  }
  $conn->close();
?>

