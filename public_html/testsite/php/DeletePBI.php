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
  if($pbiId == null || $pbiId == ""){ 
    exit("Error: PBI ID is null or empty");
  }
  else{
  //Query to insert items into audit table
  $query2 =  "INSERT INTO backlog_items_audit2 (time, email_address, action, old_title, old_description, old_effort, old_priority, old_state, old_iteration, old_project)
      VALUES (now(), '{$_SESSION['SESS_EMAIL_ADD']}', 'Delete', '$pbiTitle', '$pbiDesc', '$pbiEffort', (select priority_id from priority where description = '$pbiPriority'),(select state_id from states where state_name = '$pbiState' and state_type = 'PBI'), (select iteration_id from iteration where iteration_name = '$pbiIteration'), (select project_id from project where project_name = '$pbiProject'))";  
    
   $firstquery = mysql_query($query2);
   $secondquery = mysql_query($query);
   
   
    if ($conn->query($secondquery) === TRUE) {
     // $date = date('Y-m-d H:i:s');
     //Query to delete the backlog item where matching the pbi_id
      $query = 
      "DELETE FROM backlog_items WHERE pbi_id = '$pbiId'";
      
      if ($conn->query($firstquery) === TRUE) {
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
