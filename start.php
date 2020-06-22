<?php
$myPDO = new PDO('sqlite:tasks.db');
$sql = "CREATE TABLE IF NOT EXISTS users (
		id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
		login TEXT,
		password TEXT,
		status TEXT);";
$myPDO->query($sql);
$sql = "INSERT INTO users (login, password, status) VALUES ('root', '2a45baf6dba6249e24e5c66b9410cf62', 'admin')";
$myPDO->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS tasks (
		id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
		task TEXT,
		status TEXT,
		user_id INTEGER,
		FOREIGN KEY(user_id) REFERENCES users(id));";
$myPDO->query($sql);
$sql = "INSERT INTO tasks (task, status, user_id) VALUES ('test task', 'task-done', 1)";
$myPDO->query($sql);
$sql = "INSERT INTO tasks (task, status, user_id) VALUES ('Second task', '', 1)";
$myPDO->query($sql);
