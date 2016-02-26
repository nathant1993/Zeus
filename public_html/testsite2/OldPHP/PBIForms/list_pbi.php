<?php
$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="backlog_items"; // Table name 

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$sql="SELECT * FROM $tbl_name";
$result=mysql_query($sql);
?>

<table width="800" border="0" cellspacing="1" cellpadding="0">
<tr>
<td>
<table width="800" border="1" cellspacing="0" cellpadding="3">
<tr>
<td colspan="10"><strong>List records from Backlog Items </strong> </td>
</tr>

<tr>
<td align="center"><strong>ID</strong></td>
<td align="center"><strong>Title</strong></td>
<td align="center"><strong>Description</strong></td>
<td align="center"><strong>Effort</strong></td>
<td align="center"><strong>Priority</strong></td>
<td align="center"><strong>State</strong></td>
<td align="center"><strong>Iteration</strong></td>
<td align="center"><strong>Project</strong></td>
<td align="center"><strong>Update</strong></td>
<td align="center"><strong>Delete</strong></td>
</tr>

<?php
while($rows=mysql_fetch_array($result)){
?>

<tr>
<td><? echo $rows['pbi_id']; ?></td>
<td><? echo $rows['pbi_title']; ?></td>
<td><? echo $rows['pbi_description']; ?></td>
<td><? echo $rows['pbi_effort']; ?></td>
<td><? echo $rows['priority_id']; ?></td>
<td><? echo $rows['state_id']; ?></td>
<td><? echo $rows['iteration_id']; ?></td>
<td><? echo $rows['project_id']; ?></td>

<td align="center"><a href="update_pbi.php?pbi_id=<? echo $rows['pbi_id']; ?>">update</a></td>
<td align="center"><a href="delete_pbi_ac.php?pbi_id=<? echo $rows['pbi_id']; ?>">delete</a></td>
</tr>

<?php
}
?>

</table>
</td>
</tr>
</table>

<?php
mysql_close();
?>