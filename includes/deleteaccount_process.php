<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

if (isset($_POST['deleteaccount_button'])) {
 
	$stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->close();
	
	session_destroy();
	header('Location: ../account-deleted');
}
?>
