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
  $pbiId = $_POST["postedID"];
  $pbiTitle = mysqli_escape_string($conn,$_POST["postedTitle"]);
  $pbiDesc = mysqli_escape_string($conn,$_POST["postedDesc"]);
  $pbiEffort = $_POST["postedEffort"];
  $pbiPriority = $_POST["postedPriority"];
  $pbiState = $_POST["postedState"];
  $pbiIteration = $_POST["postedIteration"];
  $pbiProject = $_POST["postedProject"];
  
  //Check for a Null pbiID coming from the front end and throw and error 
  if($pbiId == null || $pbiId == ""){ 
    exit("Error: PBI ID is null or empty");
  }
  else{
  //Query to update a PBI based on the ID of that PBI
    $query = 
    "INSERT INTO backlog_items_audit2 (time, email_address, action, pbi_id, old_title, old_description, old_effort, old_priority, old_state, old_iteration, old_project)
      VALUES (now(), '{$_SESSION['SESS_EMAIL_ADD']}', 'Delete', '$pbiId', '$pbiTitle', 
      '$pbiDesc', 
      '$pbiEffort', 
      (select priority_id from priority where description = '$pbiPriority'),
      (select state_id from states where state_name = '$pbiState' and state_type = 'PBI'),
      (select iteration_id from iteration where iteration_name = '$pbiIteration'),
      (select project_id from project where project_name = '$pbiProject'))";

    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
    //     echo "PBI Updated successfully";
    } else {
    //     echo "Error: " . $query . "<br>" . $conn->error;
    }
     $query =     
      "DELETE FROM backlog_items where pbi_id = '$pbiId'";
      
    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
    //     echo "PBI Updated successfully";
    } else {
    //     echo "Error: " . $query . "<br>" . $conn->error;
    }
  }
  $conn->close();
?>

