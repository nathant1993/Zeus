<?php
  
  //PHP file to create a PBI
  
  // Connecting to the MySQL server
//   $host="10.168.1.92";
//   $user_name="wearezeu_phpserv";
//   $pwd="0!ZeusPhP!0";
//   $dbName="wearezeu_test01";

  include('DatabaseCon.php');
    
  // Create connection
  $conn = new mysqli($host, $user_name, $pwd, $dbName);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 

  // Storing form values into PHP variables
  $taskId = $_POST["postedID"];
  
  //Check for a Null pbiID coming from the front end and throw and error 
  if($taskId == null || $taskId == ""){ 
    exit("Error: PBI ID is null or empty");
  }
  else{
  //Query to update a PBI based on the ID of that PBI
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

