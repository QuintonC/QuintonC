<?php

session_start();
require_once("db_constant.php");


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	# check connection
	if ($mysqli->connect_errno) {
		echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
		exit();
	}

#Get from url
$psid = $_GET['id'];

$seller = $_SESSION['username'];

#Get username and id that belongs to the listing
$mysql = "select username, bid from Pending_Sale where psid = '$psid'";
$result = $conn->query($mysql);
$row = mysqli_fetch_array($result);
$buyer = $row['username'];
$bid = $row['bid'];

#Select card id and user id 
$sql = "SELECT c.cid, b.aid FROM CardInfo AS c, Buy_Listing AS b, User_Accounts AS a WHERE b.bid = '$bid' AND b.aid = a.aid AND a.aid = c.aid";
$content = $conn->query($sql);
$set = mysqli_fetch_array($content);
$cid = $set['cid'];
$aid = $set['aid'];

#Delete listing from pending table
$sql1 = "delete from Pending_Sale where bid = '$bid'";
$conn->query($sql1);

#Insert into trsnactions table to finalize
$sql2 = "insert into B_Transactions (buyer, seller, bid, cid, aid) values ('$buyer','$seller','$bid','$cid','$aid')";

if ($conn->query($sql2) === TRUE) {
	header("Location: fm_account.php");
	exit;
} else {
	echo "Error: " . $sql2 . "<br>" . $conn->error;
	
}


#$accept = "buyoffer_accept";
#$date = date("Y-m-d H:i:s");

#$sql3 = "select username from Pending_Sale where psid = '$psid'";
#$record = $conn->query($sql3);
#$item - mysqli_fetch_array($record);
#$username = $item['username'];

#Create Notification
#$sql4 = "INSERT INTO Notifications(recipient,sender,types,created,psid) VALUES('$username','$seller','$accept','$date','$psid')";

#if ($conn->query($sql4) === TRUE) {
#	header("Location: fm_account.php");
#	exit;
#} else {
#	echo "Error: " . $sql4 . "<br>" . $conn->error;
	
#}


?>