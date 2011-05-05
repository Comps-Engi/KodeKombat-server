<?php
session_start();
session_destroy();
mysql_close($con);
header('Location: http://localhost/dge/index.php');
?>
