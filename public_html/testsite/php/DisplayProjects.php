<?php
  // Connecting to the MySQL server
  $host="10.168.1.92";
  $user_name="wearezeu_phpserv";
  $pwd="0!ZeusPhP!0";
  $dbName="wearezeu_test01";
   
  //Start session
  session_start();
      
  // Create connection
  $conn = new mysqli($host, $user_name, $pwd, $dbName);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 
  
  $SprintsQuery = "SELECT a.project_id AS 'id', a.project_name AS 'name'
                        FROM project a 
                        inner join users_projects b where b.project_id = a.project_id and user_id = '".$_SESSION['SESS_MEMBER_ID']."'";

  $SprintResult = $conn->query($SprintsQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($SprintResult, MYSQL_ASSOC)) {
	   $ProjectsArray[] = array(
        'projectID' => $row['id'],
        'projectName' => $row['name'],
        'userRole' => $_SESSION['SESS_ROLE_ID']
        );
	}
  
	echo json_encode($ProjectsArray);

  $conn->close();
?>

