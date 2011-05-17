<?php
if(!isset($_SESSION['id']))
{
    require_once 'setup.php';

    $uname = $_POST["username"];
    $passwd = $_POST["passwd"];
    $pwd = db_query("SELECT ENCODE('%s', 'dge')", $passwd);
    $pwdr = mysql_fetch_array($pwd);

    $result = db_query("SELECT passwd FROM contestant WHERE uname='%s'", $uname);
    $resultr = mysql_fetch_array($result);

    if($pwdr[0] == $resultr[0])
    {
        session_start();
        $id = mysql_result(db_query("SELECT id FROM contestant WHERE uname='%s'", $uname), 0);
        $_SESSION['id'] = $id;
            redirect( 'profile.php/?success=1' );
    }
    else
            redirect( 'index.php/?success=0' );
}
?>
