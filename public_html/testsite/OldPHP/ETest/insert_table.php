

// Insert into table
<?php

$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="users_test"; // Table name
// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// Get values from form 
$Forename=$_POST['forename'];
$Surname=$_POST['surname'];
$Email=$_POST['email'];
$UserPassword=$_POST['password'];


// Insert data into mysql 
$sql="INSERT INTO $tbl_name(user_forename, user_surname, user_email, user_password)VALUES('$Forename', '$Surname', '$Email', '$Password')";
$result=mysql_query($sql);

// if successfully insert data into database, displays message "You have successfully registered". 
if($result){
echo "You have successfully registered";
echo "<BR>";
echo "<a href='insert.php'>Back to main page</a>";
}

else {
echo "ERROR";
echo $forename;
echo $surname;
echo $Email;
echo $UserPassword;
}
?> 

<?php 
// close connection 
mysql_close();
?>