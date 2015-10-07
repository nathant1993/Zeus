<?php
function connect(){	
  $host="10.168.1.92"; //host
  $uname="wearezeu_phpserv";  //username
  $pass="0!ZeusPhP!0";      //password
  $db= 'wearezeu_test01';  //database name
  
  $con = mysql_connect($host,$uname,$pass);
  
  if (!$con){
    die('Could not connect: ' . mysql_error());
  }
  
  mysql_select_db($db, $con);
}
?>

