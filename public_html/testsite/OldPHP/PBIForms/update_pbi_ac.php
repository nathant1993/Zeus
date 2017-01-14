<?php
$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="backlog_items"; // Table name 

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$pbi_title = $_POST["pbi_title"];
$pbi_description = $_POST["pbi_description"];
$pbi_effort = $_POST["pbi_effort"];
$priority_id = $_POST["priority_id"];
$state_id = $_POST["state_id"];
$iteration_id = $_POST["iteration_id"];
$project_id = $_POST["project_id"];
$pbi_id = $_POST['pbi_id'];

// update data in mysql database 
$sql="UPDATE $tbl_name SET pbi_title='$pbi_title', pbi_description='$pbi_description', pbi_effort='$pbi_effort', priority_id='$priority_id', state_id='$state_id', iteration_id='$iteration_id', project_id='$project_id' WHERE pbi_id='$pbi_id'";
$result=mysql_query($sql);

// if successfully updated. 
if($result){
	echo "Successful";
	echo "<BR>";
	echo "<a href='list_pbi.php'>Return to Backlog Items</a>";
	
	}
else {
// display error
	echo "ERROR";
	
	}
?>