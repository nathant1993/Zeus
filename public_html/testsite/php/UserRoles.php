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
  
  $userRolesQuery = "SELECT a.user_role_id AS 'id', a.user_role_description AS 'description' 
                        FROM user_roles a 
                        inner join users2 b where b.user_role_id = a.user_role_id and user_id = '".$_SESSION['SESS_MEMBER_ID']."'";

  $Result = $conn->query($userRolessQuery) or exit("Error code ({$conn->errno}): {$conn->error}");

	while ($row = mysqli_fetch_array($Result, MYSQL_ASSOC)) {
	   $UserRoleArray[] = array(
        'userRoleID' => $row['id'],
        'roleDescription' => $row['description']
        );
	}
  

  $conn->close();
?>