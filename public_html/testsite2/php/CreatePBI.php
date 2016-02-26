<?php
  
  //PHP file to create a PBI
  
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

  // Storing form values into PHP variables
  $pbiId = $_POST["postedID"];
  $pbiTitle = mysqli_escape_string($conn,$_POST["postedTitle"]);
  $pbiDesc = mysqli_escape_string($conn,$_POST["postedDesc"]);
  $pbiEffort = $_POST["postedEffort"];
  $pbiPriority = $_POST["postedPriority"];
  $pbiState = $_POST["postedState"];
  $pbiIteration = $_POST["postedIteration"];
  //$pbiProject = $_POST["postedProject"];
  $pbiProject = $_SESSION["SESS_PROJECT_ID"];
  
  //Check for a Null pbiID coming from the front end and throw and error 
  if($pbiTitle == null || $pbiTitle == ""){ 
    exit("Error: PBI Title is null or empty".$pbiProject);
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
      (select iteration_id from iteration where iteration_name = '$pbiIteration' and project_id = '$pbiProject'),
      '$pbiProject')";
    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
    //     echo "PBI Updated successfully";
    } else {
         echo "Error: " . "<br>" . $conn->error;
    }
  }
  $conn->close();
?>

