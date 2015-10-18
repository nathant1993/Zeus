<?php
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
  
  // Inserting these values into the MySQL table
  $query = "SELECT CONCAT_WS(' - ',e.project_name, b.iteration_name) 'itName', b.iteration_start_date 'itStart', b.iteration_end_date 'itEnd', b.iteration_ID 'itID'
            FROM  iteration b
            inner join releases a on a.release_id = b.release_id
            inner join project e on e.project_id = a.project_id 
            ORDER BY b.iteration_ID";

  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$SprintsArray[] = array(
		//$row
      'itName' => $row['itName'],
      'itStart' => $row['itStart'],
      'itEnd' => $row['itEnd'],
      'itID' => $row['itID']
		  );
	}

	echo json_encode($SprintsArray);

  $conn->close();
?>

