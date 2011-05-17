<?php
include 'setup.php';
$id = mysql_result(db_query("SELECT MAX(id) FROM contestant"), 0);
$id++;
$name = $_POST["name"];
$email = $_POST["email"];
$contact = $_POST["contact"];
$uname = $_POST["uname"];
$passwd = $_POST["pass1"];

$result = db_query("INSERT INTO contestant VALUES " .
                   "(%d, '%s', '%s', '%s', '%s', ENCODE('%s', 'dge'))",
                    $id, $name, $email, $contact, $uname, $passwd
            );

if($result!=false) {

    $_SESSION['id'] = $id;
    redirect( 'profile.php/?newusr=1' );
}
else {
    throw new ServerException('Could not create the user. Try again.');
}
?>
