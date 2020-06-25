<?php
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

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
	return ['id' => $row['id'], 'status' => $row['status']];
}

function getUserTasks($id, $myPDO)
{
	$query = "SELECT * FROM tasks WHERE $id = user_id";
	$rows = $myPDO->query($query)->fetchAll();
	return $rows;
}
function addTasks($text, $user_id, $status, $myPDO)
{
	$text = trim($text);
	$res = $myPDO->query("INSERT INTO tasks (task, status, user_id) VALUES ('$text', '$status', $user_id)");
	$lastRowid = $myPDO->query("SELECT last_insert_rowid()")->fetch();
	if(!$res or !$lastRowid)
		return false;
	return $lastRowid;
}

function editTask($id, $user_id, $text, $status, $myPDO)
{
	$text = trim($text);
	$res = $myPDO->query("UPDATE tasks SET status = '$status', task = '$text' WHERE $user_id = user_id AND $id = id");
	if(!$res)
		return false;
	return true;
}

function deleteTask($id, $user_id, $myPDO)
{
	$res = $myPDO->query("DELETE FROM tasks WHERE $user_id = user_id AND $id = id");
	if(!$res)
		return false;

	return true;
}
/////////////////////// admin

function getAllUsers($myPDO)
{	
	$sql = "SELECT * FROM users";
	$users = $myPDO->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	
	$sql = 'SELECT tasks.*, users.id as userId, users.login, users.password, users.status
		FROM tasks LEFT JOIN users ON tasks.user_id = users.id';
	$rows = $myPDO->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	
	$arr = [];
	foreach($rows as $row) {
		$arr[$row['userId']][] = $row;
	}

	$usersWithTasks = array_map(function($user) use ($arr){
		$user['tasks'] = $arr[$user['id']];
		return $user;
	},$users);
	
	return $usersWithTasks;
}
function deleteUser($userId, $myPDO)
{
	$myPDO->query("DELETE FROM tasks WHERE $userId = user_id");
	$res = $myPDO->query("DELETE FROM users WHERE $userId = id");
	
	if(!$res)
		return false;

	return true;
}

function changeStatus($userId, $myPDO) 
{
	$res = $myPDO->query("
		UPDATE users SET status = CASE
			WHEN status = 'admin' THEN 'user'
			WHEN status = 'user' THEN 'admin'
		END 
		WHERE $userId = id
	");
	if(!$res)
		return false;
	return true;
}


