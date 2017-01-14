<?php
  
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
  $stateId = $_POST["postedStateID"];
  $taskName = $_POST["postedTaskName"];
  $taskId = substr($taskName,4);
  
  //Check for a Null pbiID coming from the front end and throw and error 
  //if($stateId >= 7){ 
    $query = "UPDATE task SET state_id = '$stateId' WHERE task_id = '$taskId' ";

    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
    //     echo "PBI Updated successfully";
    } else {
         echo "Error: " . $query . "<br>" . $conn->error;
    }    
  //}
  
  // else{
  // //Query to update a PBI based on the ID of that PBI
  // //exit("Error: PBI Title is null or empty");  
  // }
  
  echo $stateId, $taskName, $taskId;
  
  $conn->close();
?>

