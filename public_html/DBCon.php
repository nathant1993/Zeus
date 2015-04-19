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
  $emailAddress = $_POST["postemail"];
  //$emailAddress=mysql_real_escape_string($emailAddress);
  

  // Inserting these values into the MySQL table
  $query = "insert into InterestedEmailAds (EmailAddress) values ('$emailAddress')";
  
  if ($conn->query($query) === TRUE) {
      //echo "New record created successfully"
	  header("Location: http://www.wearezeus.co.uk/indexdev.html");
  } else {
      //echo "Error: " . $query . "<br>" . $conn->error;
	  header("Location: http://www.wearezeus.co.uk/indexdev.html");
  }

  $conn->close();
?>

