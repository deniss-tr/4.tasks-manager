<?php

function register($myPDO, $login, $password)
{	
	global $message;	
	$query = "SELECT * FROM users WHERE login = '$login'";
	$row = $myPDO->query($query)->fetch();
	if(!$row) {
		$res = $myPDO->query("INSERT INTO users (login, password, status) VALUES ('$login', '$password', 'user')");
		if($res){
			$message = "Account Successfully Created";
			return true;
		} else {
			$message = "Failed to insert data information!";
		}
	} else {
		$message = "Sory this login already taken";
	}

	return false;
	
}
function login($myPDO, $login, $password)
{
	global $message;	
	$query = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
	$row = $myPDO->query($query)->fetch();
	if(!$row){
		$message = "Incorrect login or password";
		return false;
	}
	return $row['id'];
}	


