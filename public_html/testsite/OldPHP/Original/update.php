<?php
$host="10.168.1.92"; // Host name 
$username="wearezeu_phpserv"; // Mysql username 
$password="0!ZeusPhP!0"; // Mysql password 
$db_name="wearezeu_test01"; // Database name 
$tbl_name="test"; // Table name

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// get value of id that sent from address bar
$id=$_GET['id'];

// Retrieve data from database 
$sql="SELECT * FROM $tbl_name WHERE id='$id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
?>

<table width="400" border="0" cellspacing="1" cellpadding="0">
<tr>
<form name="form1" method="post" action="update_ac.php">
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td>&nbsp;</td>
<td colspan="3"><strong>Update data in mysql</strong> </td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center"><strong>testfield1</strong></td>
<td align="center"><strong>testfield2</strong></td>
<td align="center"><strong>testfield3</strong></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">
<input name="testfield1" type="text" id="testfield1" value="<? echo $rows['testfield1']; ?>">
</td>
<td align="center">
<input name="testfield2" type="text" id="testfield2" value="<? echo $rows['testfield2']; ?>" size="15">
</td>
<td>
<input name="testfield3" type="text" id="testfield3" value="<? echo $rows['testfield3']; ?>" size="15">
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<input name="id" type="hidden" id="id" value="<? echo $rows['id']; ?>">
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