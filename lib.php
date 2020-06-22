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
		$message = "Sorry this login already taken";
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

function getUserTasks($id, $myPDO)
{
		$query = "SELECT * FROM tasks WHERE $id = user_id";
		$rows = $myPDO->query($query)->fetchAll();
		return $rows;
}
function addTasks($text, $user_id, $status, $myPDO)
{
	$res = $myPDO->query("INSERT INTO tasks (task, status, user_id) VALUES ('$text', '$status', $user_id)");
	$lastRowid = $myPDO->query("SELECT last_insert_rowid()")->fetch();
	if(!$res or !$lastRowid)
		return false;
	return $lastRowid;
}
function deleteTask($id, $user_id, $myPDO)
{
	$res = $myPDO->query("DELETE FROM tasks WHERE $user_id = user_id AND $id = id");
	if(!$res)
		return false;

	return true;
}
