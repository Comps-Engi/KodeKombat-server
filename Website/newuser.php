<?php
include 'conn.php';
$id = mysql_result(mysql_query("SELECT MAX(id) FROM contestant"), 0);
$id++;
$name = $_POST["name"];
$email = $_POST["email"];
$contact = $_POST["contact"];
$uname = $_POST["uname"];
$passwd = $_POST["pass1"];
$result = mysql_query("INSERT INTO contestant VALUES ($id, '$name', '$email', $contact, '$uname', ENCODE('$passwd', 'dge'))");
if($result!=false)
{
	session_start();
	$_SESSION['id'] = $id;
	header( 'Location: http://localhost/dge/profile.php/?newusr=1' );
}
else
{
	echo "Error";
}
?>
