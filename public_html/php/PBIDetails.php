<?php
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
  $PBIID = $_POST["postedPBIID"];

  $query = 
     "SELECT pbi_id, pbi_title, pbi_description, pbi_effort, c.description as 'priority', d.state_name 'state', b.iteration_name 'itName'
            FROM  backlog_items a
            right outer join iteration b on b.iteration_ID = a.iteration_ID
            inner join priority c on c.priority_id = a.priority_id
            inner join states d on d.state_id = a.state_id
            where  pbi_id = '$PBIID'";     
    
  // if ($conn->query($query) === TRUE) {
  //     //echo "New record created successfully"
	//   //header("Location: http://www.wearezeus.co.uk/indexdev.html");
  // } else {
  //     //echo "Error: " . $query . "<br>" . $conn->error;
	//   //header("Location: http://www.wearezeus.co.uk/indexdev.html");
  // }
  
  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");


	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$PBIDetails[] = array(
		//$row
			'pbiId' => $row['pbi_id'],
			'pbiTitle' => $row['pbi_title'],
      'pbiDesc' => $row['pbi_description'],
      'pbiEff' => $row['pbi_effort'],
      'priority'=> $row['priority'],
      'state' => $row['state'],
      'itName' => $row['itName'],
      //'project' => $row['projName'],
		  );
	}

	echo json_encode($PBIDetails);

  $conn->close();

?>

