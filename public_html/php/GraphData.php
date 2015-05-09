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

  // Storing form values into PHP variables
  //$emailAddress = $_POST["emailAddress"]; // Since method="post" in the form
  //$emailAddress = $_POST["postemail"];
  //$emailAddress=mysql_real_escape_string($emailAddress);
  

  // Inserting these values into the MySQL table
  $query = "SELECT a.iteration_id, iteration_name, SUM( PBI_effort ) as 'effort', starting_effort, (starting_effort - (SUM(pbi_effort))) as 'remaining_effort'
	FROM  backlog_items a
	Inner join iteration b on b.iteration_ID = a.iteration_ID
	GROUP BY iteration_id, iteration_name";
  /*
	"SELECT a.iteration_id, iteration_name, SUM( PBI_effort ) as 'effort'
	FROM  backlog_items a
	Inner join iteration b on b.iteration_ID = a.iteration_ID
	GROUP BY iteration_id, iteration_name";
  */
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
			'effCom' => $row['effort'],
      'effTot' => $row['starting_effort'],
      'effRem' => $row['remaining_effort'],
		  );
	}


	
	echo json_encode($grapharray);
	
	
  //if ($result->num_rows > 0) {
     // output data of each row
		//var_dump(mysql_fetch_assoc($result));
	//	while($row = $result->fetch_assoc()) {
	//		var_dump($row);}
		//	echo "<br> id: ". $row["a.iteration_id"]. " - Name: ". $row["iteration_name"]. " " . $row["SUM( PBI_effort )"] . "<br>";}
	//} 
	//else {
	//	echo "0 results";
	//}
  
	  //header("Location: http://www.wearezeus.co.uk/index.html");


  $conn->close();
?>

