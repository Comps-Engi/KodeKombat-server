<?php
include 'setup.php';

$id = $_SESSION['id'];

$fileName = $_FILES['bot']['name'];
$tmpName  = $_FILES['bot']['tmp_name'];
$fileSize = $_FILES['bot']['size'];
$fileType = $_FILES['bot']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));

fclose($fp);

$res = mysql_fetch_array(db_query("SELECT botID FROM bot where contestantID=%d", $id));
if($res[0])
{
    $query = db_query("UPDATE bot SET code='%s' WHERE contestantID=%d",
                $content, $id);
    if (!$query) {
        throw new ServerException('Could not update the bot.');
    }
}
else
{
    $token = mysql_fetch_array(db_query("SELECT MIN(token) FROM bot"));
    $token = $token[0];

?>
<pre class="bot-content">
    <?php echo htmlspecialchars($content) ?>
</pre>
<?php
    $query = db_query("INSERT INTO bot (filesize, filetype, contestantID, code, sflag, token, score) VALUES ($fileSize, '$fileType', $id, '$content', 0, $token, 2500)");
}
if($query !=false)
    redirect( 'profile.php/?upload=1' );
else
    throw new ServerException('An error occured while saving the bot.');
?>
