<?php
  //PHP file to create a Sprint
  
  // Connecting to the MySQL server
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
  $sprintName = mysqli_escape_string($conn,$_POST["postedName"]);
  $startDate = $_POST["postedStartDate"];
  $endDate = $_POST["postedEndDate"];
  $projectID = $_SESSION["SESS_PROJECT_ID"];
   
  //Check for a Null sprint name coming from the front end and throw and error 
  if($sprintName == null || $sprintName == ""){ 
    exit("Error: Sprint Name is null or empty");
  }
  
  else{
  //Query to create a Sprint
    $query = 
      "Insert into iteration
      (iteration_name, iteration_start_date, iteration_end_date, release_id, starting_effort, project_id)
      values
      ('$sprintName', 
      '$startDate', 
      '$endDate',
      1,
      297,
      '$projectID')";
    
    //Run the query and provide feedback on how the update went
    if ($conn->query($query) === TRUE) {
         echo "Sprint successfully created";
    } else {
         echo "Error: <br>" . $conn->error;
    }
  }
  $conn->close();
?>

