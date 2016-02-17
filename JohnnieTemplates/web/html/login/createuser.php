<?php
include_once 'config.php';
	//Pull username, generate new ID and hash password
	$newid = uniqid (rand(), false);
	$newuser = $_POST['username'];
	$newpw = password_hash($_POST['userpass1'], PASSWORD_DEFAULT);
	$pw1 = $_POST['userpass1'];
	$pw2 = $_POST['userpass2'];
?>