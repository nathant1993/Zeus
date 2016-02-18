<?php
  // Connecting to the MySQL server
//   $host="10.168.1.92";
//   $user_name="wearezeu_phpserv";
//   $pwd="0!ZeusPhP!0";
//   $dbName="wearezeu_test01";

  include('DatabaseCon.php');
   
  //Start session
  session_start();
  
  $ProjectID = $_POST["postedProjectID"];

  $_SESSION["SESS_PROJECT_ID"] = $ProjectID;
  
  echo $_SESSION["SESS_PROJECT_ID"];  
?>
      