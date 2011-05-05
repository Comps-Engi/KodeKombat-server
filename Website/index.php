
<?php
session_start();
if(isset($_SESSION['id']))
	header('Location: http://localhost/dge/profile.php');
?>
<html>
<head>
<title>Distributed Game Engine</title>
<script type="text/javascript">
function check()
{
	var uname = document.getElementById("username");
	var passwd = document.getElementById("passwd");
	if (uname.value=="" || uname==null)
	{
		alert("Please enter your user name");
		return false;
	}
	if (passwd.value=="" || passwd==null)
	{
		alert("Please enter your password");
		return false;
	}
	else
	{
		doucument.forms["login"].submit();
	}
}
</script>
</head>
<body>
<center>
<form id="login" action="http://localhost/dge/login.php" onsubmit="return check()" method="post">
<table>
<tr><td>User name:</td><td><input type="text" size="10" id = "username" name="username" /></td></tr>
<tr><td>Password:</td><td><input type="password" size="10" id = "passwd" name="passwd" /></td></tr>
</table>
<input type="submit" value = "Login" />
</form>
<?php
if(isset($_GET["success"]))
{
	if($_GET["success"] == 0)
		echo "<div style=\"color:red\">Wrong username or password</div>";
}
?>
Not a user? <a href="signup.html">Sign Up</a>
<center>
</body>
</html>
