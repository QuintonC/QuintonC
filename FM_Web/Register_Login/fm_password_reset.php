<?php
//session_start();
require_once("../db_constant.php");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL:" .mysqli_connect_error();
	}

$newpass = $_POST['newpass'];
$newpass1 = $_POST['newpass1'];
$post_username = $_POST['username'];
$token = $_GET['token'];

//  Prevent MySQL injection 
$newpass = strip_tags($newpass);
$newpass1 = strip_tags($newpass1);
$post_username = strip_tags($post_username);
$token = strip_tags($token);

$newpass = stripslashes($newpass);
$newpass1 = stripslashes($newpass1);
$post_username = stripslashes($post_username);
$token = stripslashes($token);


if($newpass == $newpass1)
{
	$encpw = password_hash($newpass, PASSWORD_BCRYPT);
	
	$query4 = "UPDATE User_Accounts SET password='$encpw' WHERE username='$post_username'";
	$conn->query($query4);
	
	$query5 = "UPDATE User_Accounts SET token='0' WHERE username='$post_username'";
	$conn->query($query5);
	
	echo '<script type="text/javascript"> alert("Password changed."); window.location="fm_login.html";</script>';
}
else
{
	echo '<script type="text/javascript"> alert("Passwords must match."); window.location="fm_recover_password.php";</script>';
}

?>