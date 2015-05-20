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
  $query = "SELECT pbi_id, pbi_title, pbi_description, pbi_effort, c.description as 'priority', d.state_name, b.iteration_name, e.project_name
            FROM  backlog_items a
            right outer join iteration b on b.iteration_ID = a.iteration_ID
            inner join priority c on c.priority_id = a.priority_id
            inner join states d on d.state_id = a.state_id
            inner join project e on e.project_id = a.project_id
            where b.iteration_start_date <= sysdate() 
            and b.iteration_end_date >= sysdate()";

  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");


	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$grapharray[] = array(
		//$row
			'pbiId' => $row['pbi_id'],
			'pbiTitle' => $row['pbi_title'],
      'pbiDesc' => $row['pbi_description'],
      'pbiEff' => $row['pbi_effort'],
      'priority'=> $row['priority'],
      'state' => $row['d.state_name'],
      'itId' => $row['b.iteration_name'],
      'project' => $row['e.project_name'],
		  );
	}

	echo json_encode($grapharray);
	
	

  $conn->close();
?>

