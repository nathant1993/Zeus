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

  $query = 
	"SELECT a.iteration_id, iteration_name, SUM( PBI_effort ) as 'effort'
	FROM  backlog_items a
	Inner join iteration b on b.iteration_ID = a.iteration_ID
	GROUP BY iteration_id, iteration_name";
  $result = $conn->query($query);

  //create an array
    //$grapharray[] = array();
    //while($row =mysqli_fetch_assoc($result))
    //{
    //    $grapharray[] = $row;
    //}

	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$grapharray[] = array(
		//$row
			'itName' => $row['iteration_name'],
			'effComp' => $row['effort']
		  );
	}


	
	echo json_encode($grapharray);

  $conn->close();
?>

