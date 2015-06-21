<?php

$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="test"; // Table name 

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// Get values from form 
$id=$_POST['id'];
$testfield1=$_POST['testfield1'];
$testfield2=$_POST['testfield2'];
$testfield3=$_POST['testfield3'];

// Insert data into mysql 
$sql="INSERT INTO $tbl_name(id, testfield1, testfield2, testfield3)VALUES('NULL', '$testfield1', '$testfield2', '$testfield3')";
$result=mysql_query($sql);

// if successfully insert data into database, displays message "Successful". 
if($result){
echo "Successful";
echo "<BR>";
echo "<a href='insert.php'>Back to main page</a>";
}

else {
echo "ERROR";
}
?> 

<?php 
// close connection 
mysql_close();
?>