<?php
if(!isset($_SESSION['id']))
{
	include 'conn.php';
	$uname = $_POST["username"];
	$passwd = $_POST["passwd"];
	$pwd = mysql_query("SELECT ENCODE('$passwd', 'dge')");
	$pwdr = mysql_fetch_array($pwd);
	$result = mysql_query("SELECT passwd FROM contestant WHERE uname='$uname'");
	$resultr = mysql_fetch_array($result);
	if($pwdr[0] == $resultr[0])
	{
		session_start();
		$id = mysql_result(mysql_query("SELECT id FROM contestant WHERE uname='$uname'"), 0);
		$_SESSION['id'] = $id;
			header( 'Location: http://localhost/dge/profile.php/?success=1' );
	}
	else
			header( 'Location: http://localhost/dge/index.php/?success=0' );
}
?>
