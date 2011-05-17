<?php
include 'setup.php';

if(isset($_SESSION['id']))
{
    $id      = $_SESSION['id'];
    // FIXME: Wtf!! Use an ORM!
    $name    = mysql_result(db_query("SELECT name FROM contestant WHERE id=%d", $id), 0);
    $email   = mysql_result(db_query("SELECT email FROM contestant WHERE id=%d", $id), 0);
    $contact = mysql_result(db_query("SELECT contact FROM contestant WHERE id=%d", $id), 0);
    $uname   = mysql_result(db_query("SELECT uname FROM contestant WHERE id=%d", $id), 0);
    $score   = mysql_result(db_query("SELECT score FROM bot WHERE contestantID=%d", $id), 0);
}
else
    redirect('');
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
$bid = mysql_result(db_query("Select botID from bot, contestant where bot.contestantID=contestant.id and contestant.id=%d", $id),0);
$query = db_query("Select * from matches where contestantID1=%d or contestantID2=%d ORDER BY matchid DESC LIMIT 10", $bid, $bid);
if($query)
{
    echo "<b>Matches:</b><br /><table>";

    while($row = mysql_fetch_array($query))
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
//        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[4]</td></tr>";
    }
    echo "</table>";
}
?>
<hr />
<?php
$res = mysql_result(db_query("SELECT botID FROM bot where contestantID=%d", $id), 0);
if($res)
    echo "<b>Upload bot: </b>";
else
    echo "<b>Reload bot: </b>";
?>
<form action="<?php echo make_url('upload_bot.php') ?>" method="post" enctype="multipart/form-data">
<input type="file" name="bot" id="file" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>
<a href="<?php echo make_url('close.php')?>">Log out</a>
</body>
</center>
</html>
