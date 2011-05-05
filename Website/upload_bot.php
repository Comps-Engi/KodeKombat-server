<?php
include 'conn.php';
session_start();
$id = $_SESSION['id'];

$fileName = $_FILES['bot']['name'];
$tmpName  = $_FILES['bot']['tmp_name'];
$fileSize = $_FILES['bot']['size'];
$fileType = $_FILES['bot']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = mysql_real_escape_string($content);
fclose($fp);

$res = mysql_fetch_array(mysql_query("SELECT botID FROM bot where contestantID=$id"));
if($res[0])
{
	$query = mysql_query("UPDATE bot SET code='$content' WHERE contestantID=$id");
}
else
{
	$token = mysql_fetch_array(mysql_query("SELECT MIN(token) FROM bot"));
	$token = $token[0];

	echo $content;

	$query = mysql_query("INSERT INTO bot (filesize, filetype, contestantID, code, sflag, token, score) VALUES ($fileSize, '$fileType', $id, '$content', 0, $token, 2500)");
}
if($query !=false)
	header( 'Location: http://localhost/dge/profile.php/?upload=1' );
else
	echo "ERROR"
?>
