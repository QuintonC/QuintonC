<?php

session_start();
require_once("db_constant.php");


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	# check connection
	if ($mysqli->connect_errno) {
		echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
		exit();
	}

$username = $_SESSION['username'];

#Get from url
$rid = $_GET['id'];
#Create offer for rental
$sql = "insert into Pending_Rental (username,rid) values ('$username','$rid')";

if ($conn->query($sql) === TRUE) {
	header("Location: fm_account.php");
	exit;
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

?>