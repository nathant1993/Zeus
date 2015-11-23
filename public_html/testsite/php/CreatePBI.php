<?php
  
 session_start();
  
  //PHP file to create a PBI
  
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
  $pbiId = $_POST["postedID"];
  $pbiTitle = mysqli_escape_string($conn,$_POST["postedTitle"]);
  $pbiDesc = mysqli_escape_string($conn,$_POST["postedDesc"]);
  $pbiEffort = $_POST["postedEffort"];
  $pbiPriority = $_POST["postedPriority"];
  $pbiState = $_POST["postedState"];
  $pbiIteration = $_POST["postedIteration"];
  $pbiProject = $_POST["postedProject"];
  
  //Check for a Null pbiID coming from the front end and throw and error 
  if($pbiTitle == null || $pbiTitle == ""){ 
    exit("Error: PBI Title is null or empty");
  }
  else{
  //Query to update a PBI based on the ID of that PBI
    $query = 
      "Insert into backlog_items
      (pbi_title, pbi_description, pbi_effort, priority_id, state_id, iteration_id, project_id)
      values
      ('$pbiTitle', 
      '$pbiDesc', 
      '$pbiEffort', 
      (select priority_id from priority where description = '$pbiPriority'),
      (select state_id from states where state_name = '$pbiState' and state_type = 'PBI'),
      (select iteration_id from iteration where iteration_name = '$pbiIteration'),
      (select project_id from project where project_name = '$pbiProject'))";
    
    //Insert into backlog_items (pbi_title, pbi_description, pbi_effort, priority_id, state_id, iteration_id, project_id) values ('Test', 'Testing PHP', '10', (select priority_id from priority where description = 'High'), (select state_id from states where state_name = 'New' and state_type = 'PBI'),// (select iteration_id from iteration where iteration_name = 'Sprint 12'), (select project_id from project where project_name = 'Zeus'))
    
    //Run the query and provide feedback on how the update went
   if ($conn->query($query) === TRUE) {
     // $date = date('Y-m-d H:i:s');
      $query2 =  "INSERT INTO backlog_items_audit2 (time, email_address, action, pbi_id, new_title, new_description, new_effort, new_priority, new_state, new_iteration, new_project)
      VALUES (now(), '{$_SESSION['SESS_EMAIL_ADD']}', 'Insert', (select pbi_id from backlog_items where pbi_title = '$pbiTitle'), '$pbiTitle', 
      '$pbiDesc', 
      '$pbiEffort', 
      (select priority_id from priority where description = '$pbiPriority'),
      (select state_id from states where state_name = '$pbiState' and state_type = 'PBI'),
      (select iteration_id from iteration where iteration_name = '$pbiIteration'),
      (select project_id from project where project_name = '$pbiProject'))";
      
      if ($conn->query($query2) === TRUE) {
        //successfully added to audit table
        $_SESSION["action_result"] = "success";
      } else {
        //Failed to add to audit table
         $_SESSION["action_result"] = "failed";
      }
      
    //     echo "PBI Updated successfully";
    } else {
    //     echo "Error: " . $query . "<br>" . $conn->error;
    }
  }
  $conn->close();
?>

