<?php
$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="backlog_items"; // Table name

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// get value of id that sent from address bar
$pbi_id=$_GET['pbi_id'];

// Retrieve data from database 
$sql="SELECT * FROM $tbl_name WHERE pbi_id='$pbi_id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
?>

<table width="700" border="0" cellspacing="1" cellpadding="0">
<tr>
<form name="form1" method="post" action="update_pbi_ac.php">
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td>&nbsp;</td>
<td colspan="3"><strong>Update Record</strong> </td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center"><strong>Title</strong></td>
<td align="center"><strong>Description</strong></td>
<td align="center"><strong>Effort</strong></td>
<td align="center"><strong>Priority</strong></td>
<td align="center"><strong>State</strong></td>
<td align="center"><strong>Iteration</strong></td>
<td align="center"><strong>Project</strong></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">
<input name="pbi_title" type="text" id="pbi_title" value="<? echo $rows['pbi_title']; ?>">
</td>
<td align="center">
<input name="pbi_description" type="text" id="pbi_description" value="<? echo $rows['pbi_description']; ?>" size="15">
</td>
<td>
<input name="pbi_effort" type="number" id="pbi_effort" value="<? echo $rows['pbi_effort']; ?>" size="15">
</td>
<td>
<input name="priority_id" type="number" id="priority_id" value="<? echo $rows['priority_id']; ?>" size="15">
</td>
<td>
<input name="state_id" type="number" id="state_id" value="<? echo $rows['state_id']; ?>" size="15">
</td>
<td>
<input name="iteration_id" type="number" id="iteration_id" value="<? echo $rows['iteration_id']; ?>" size="15">
</td>
<td>
<input name="project_id" type="number" id="project_id" value="<? echo $rows['project_id']; ?>" size="15">
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<input name="pbi_id" type="hidden" id="pbi_id" value="<? echo $rows['pbi_id']; ?>">
</td>
<td align="center">
<input type="submit" name="Submit" value="Submit">
</td>
<td>&nbsp;</td>
</tr>
</table>
</td>
</form>
</tr>
</table>

<?php
// close connection 
mysql_close();
?>