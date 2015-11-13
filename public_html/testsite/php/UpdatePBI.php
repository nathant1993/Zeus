<?php
  session_start();
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
      "update backlog_items
      SET pbi_title = '$pbiTitle',
      pbi_description = '$pbiDesc',
      pbi_effort = $pbiEffort,
      priority_id = (select priority_id from priority where description = '$pbiPriority'),
      state_id = (select state_id from states where state_name = '$pbiState' and state_type = 'PBI'),
      iteration_id = (select iteration_id from iteration where iteration_name = '$pbiIteration'),
      project_id = (select project_id from project where project_name = '$pbiProject')
      where pbi_id = '$pbiId'";
    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
     // $date = date('Y-m-d H:i:s');
      $query2 =  "insert into backlog_items_audit2 (time, email_address, action) values (now(), '{$_SESSION['SESS_EMAIL_ADD']}', 'Update')";
      
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

