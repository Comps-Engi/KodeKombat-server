<?php
require_once 'setup.php';

session_start();
session_destroy();
mysql_close($_con);
redirect('');
?>
