<?php
$con = mysql_connect("localhost","dge","dge123");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("dge", $con);
?>
