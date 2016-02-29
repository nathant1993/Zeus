<?php
  // // Connecting to the MySQL server
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
  
  $query =    
    "select
    @var:= IFNULL(
        (select SUM( PBI_effort ) 
            from backlog_items a 
            right outer join iteration b on b.iteration_ID = a.iteration_ID 
            where a.project_id = '".$_SESSION['SESS_PROJECT_ID']."'  
          AND b.iteration_start_date <= DATE_FORMAT(sysdate(), '%Y-%m-%d') 
            and b.iteration_end_date >= DATE_FORMAT(sysdate(), '%Y-%m-%d')
          and state_id = 4) / 
        (select 
          SUM( PBI_effort ) 
          from backlog_items a 
          right outer join iteration b on b.iteration_ID = a.iteration_ID 
          where a.project_id = '".$_SESSION['SESS_PROJECT_ID']."' 
          and b.iteration_start_date <= DATE_FORMAT(sysdate(), '%Y-%m-%d') 
            and b.iteration_end_date >= DATE_FORMAT(sysdate(), '%Y-%m-%d')
        ) * 100,0) as 'PercentageOfItEffortDone',
    100 - @var as 'PercentageOfItEffortRemaining'";
            
              
  
  $result = $conn->query($query) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$piearray[] = array(

			'effDone' => $row['PercentageOfItEffortDone'],
			'effRem' => $row['PercentageOfItEffortRemaining']
		  );
	}
  
	echo json_encode($piearray);

  $conn->close();
?>

