<?php
$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="test"; // Table name 

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$testfield1 = $_POST["testfield1"];
$testfield2 = $_POST["testfield2"];
$testfield3 = $_POST["testfield3"];
$id = $_POST['id'];

// update data in mysql database 
$sql="UPDATE $tbl_name SET testfield1='$testfield1', testfield2='$testfield2', testfield3='$testfield3' WHERE id='$id'";
$result=mysql_query($sql);

// if successfully updated. 
if($result){
	echo "Successful";
	echo "<BR>";
	echo "<a href='list_records.php'>View result</a>";
	}
else {
	echo "ERROR";
	}
?>