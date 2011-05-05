<?php
include 'conn.php';
session_start();
if(isset($_SESSION['id']))
{
	$id = $_SESSION['id'];
	$name = mysql_result(mysql_query("SELECT name FROM contestant WHERE id=$id"), 0);
	$email = mysql_result(mysql_query("SELECT email FROM contestant WHERE id=$id"), 0);
	$contact = mysql_result(mysql_query("SELECT contact FROM contestant WHERE id=$id"), 0);
	$uname = mysql_result(mysql_query("SELECT uname FROM contestant WHERE id=$id"), 0);
	$score = mysql_result(mysql_query("SELECT score FROM bot WHERE contestantID=$id"), 0);
}
else
	header("Location: http://localhost/dge/index.php");
?>
<html>
<head><title><?php echo $name ?>'s Profile</title>
</head>
<body>
<center>
<div style="color:blue">
<?php
if(isset($_GET["success"]))
{
	if($_GET["success"] == 1 && isset($_SESSION['id']))
		echo "Login successful.";
}
if(isset($_GET["newusr"]))
{
	if($_GET["newusr"] == 1 && isset($_SESSION['id']))
		echo "User created.";
}
if(isset($_GET["upload"]))
{
	if($_GET["upload"] == 1)
		echo "Bot uploaded successfully";
}
?>
</div><br /><br />
<table>
<tr><th>Name</th><td> <?php echo $name ?></td></tr>
<tr><th>E-Mail </th><td><?php echo $email ?></td></tr>
<tr><th>Contact</th><td><?php echo $contact ?></td></tr>
<tr><th>Username</th><td><?php echo $uname ?></td></tr>
<tr><th>Score</th><td><?php echo $score ?></td></tr>
</table>
<hr />
<?php
$bid = mysql_result(mysql_query("Select botID from bot, contestant where bot.contestantID=contestant.id and contestant.id=$id"),0);
$query = mysql_query("Select * from matches where contestantID1=$bid or contestantID2=$bid ORDER BY matchid DESC LIMIT 10");
if($query)
{
	echo "<b>Matches:</b><br /><table>";
	$row = mysql_fetch_array($query);
	do
	{
		if ($row[0]==$bid)
		{
			if ($row[4]=0)
				echo "Match $row[2] won against bot $row[1]<br />";
			else
				echo "Match $row[2] lost against bot $row[1]<br />";
		}
		elseif($row[1] = $bid)
		{
			if  ($row[4]=0)
				echo "Match $row[2] lost against bot $row[0]<br />";
			else
				echo "Match $row[2] won against bot $row[0]<br />";
		}
//		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[4]</td></tr>";
		$row = mysql_fetch_array($query);
	}while($row);
	echo "</table>";
}
?>
<hr />
<?php
$res = mysql_result(mysql_query("SELECT botID FROM bot where contestentID=$id"), 0);
if($res)
	echo "<b>Upload bot: </b>";
else
	echo "<b>Reload bot: </b>";
?>
<form action="http://localhost/dge/upload_bot.php" method="post" enctype="multipart/form-data">
<input type="file" name="bot" id="file" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>
<a href="http://localhost/dge/close.php">Log out</a>
</body>
</center>
</html>
