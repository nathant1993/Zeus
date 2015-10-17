<?php
function connect(){	
  $host="10.168.1.92"; //host
  $uname="wearezeu_phpserv";  //username
  $pass="0!ZeusPhP!0";      //password
  $db= 'wearezeu_test01';  //database name
  
  //Connect using the host, username and password given
  $con = mysql_connect($host,$uname,$pass);
  
  //If connection cannot be made then output an error
  if (!$con){
    die('Could not connect: ' . mysql_error());
  }
  
  //Select the database using the database name given
  mysql_select_db($db, $con);
}
?>

