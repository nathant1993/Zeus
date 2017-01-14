<?php

$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="backlog_items"; // Table name 

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// Get values from form 
$pbi_id=$_POST['pbi_id'];
$pbi_title=$_POST['pbi_title'];
$pbi_description=$_POST['pbi_description'];
$pbi_effort=$_POST['pbi_effort'];
$priority_id=$_POST['priority_id'];
$state_id=$_POST['state_id'];
$iteration_id=$_POST['iteration_id'];
$project_id=$_POST['project_id'];

// Insert data into mysql 
$sql="INSERT INTO $tbl_name(pbi_id, pbi_title, pbi_description, pbi_effort, priority_id, state_id, iteration_id, project_id)VALUES('NULL', '$pbi_title', '$pbi_description', '$pbi_effort', '$priority_id', '$state_id', '$iteration_id', '$project_id')";
$result=mysql_query($sql);

// if successfully insert data into database, displays message "Successful". 
if($result){
echo "Successful";
echo "<BR>";
echo "<a href='insert_pbi.php'>Back to main page</a>";
}

else {
echo "ERROR";
}
?> 

<?php 
// close connection 
mysql_close();
?>