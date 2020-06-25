<?php
$myPDO = new PDO('sqlite:tasks.db');
require_once("lib.php");

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Middleware\MethodOverrideMiddleware;
require 'vendor/autoload.php';

session_start();
$container = new Container();
$container->set('renderer', function () {
    return new Slim\Views\PhpRenderer(__DIR__ . '/templates');
});
$container->set('flash', function () {
    return new Slim\Flash\Messages();
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);
$app->add(MethodOverrideMiddleware::class);
$message = 'init';

$app->get('/', function ($request, $response) {
	if(!isset($_SESSION["session_login"])){
		return $response->withRedirect('/login', 301);
	} else {
		if($_SESSION["session_user_status"] == 'admin') {
			return $response->withRedirect('/admin', 301);
		}
		return $response->withRedirect('/tasks', 301);
	}
});
$app->get('/login', function ($request, $response) {
	$flash = $this->get('flash')->getMessages();
    return $this->get('renderer')->render($response, 'login.php', $flash);
});

$app->get('/register', function ($request, $response) {
	$flash = $this->get('flash')->getMessages();
    return $this->get('renderer')->render($response, 'register.php', $flash);
});

$app->post('/register', function ($request, $response) use ($myPDO) {
	global $message;
	$login = $request->getParsedBodyParam('login');
	$password = $request->getParsedBodyParam('password');
	$password = md5(md5($password).'todo');

	if(!$login or !$password) {
		return $response->write("Empty login or password, back to  <a href='/register'>register</a>");
	}

	if(register($myPDO, $login, $password)){
		$this->get('flash')->addMessage('success', $message);
		return $response->withRedirect('/login', 301);
	}

	$this->get('flash')->addMessage('warning', $message);
    return $response->withRedirect('/register', 301);
});

$app->post('/login', function ($request, $response) use ($myPDO) {
	global $message;
	$login = $request->getParsedBodyParam('login');
	$password = $request->getParsedBodyParam('password');
	
	if(!$login or !$password) {
		return $response->write("Empty login or password, back to  <a href='/register'>register</a>");
	}
	$password = md5(md5($password).'todo');
	$user = login($myPDO, $login, $password);
	$user_id = $user['id'];
	$user_status = $user['status'];
	
	if(!$user_id){
		$this->get('flash')->addMessage('warning', $message);
		return $response->withRedirect('/login', 301);
	}

	$_SESSION["session_login"] = $login;
	$_SESSION["session_user_id"] = $user_id;
	$_SESSION["session_user_status"] = $user_status;
	
	if($user_status == 'admin') {
		return $response->withRedirect('/admin', 301);
	}
	
	return $response->withRedirect('/tasks', 301);
});
$app->get('/logout', function ($request, $response) {

	unset($_SESSION['session_login']);
	unset($_SESSION['session_user_id']);
	unset($_SESSION['session_user_status']);
	session_destroy();

    return $response->withRedirect('/login', 301);
});
$app->get('/tasks', function ($request, $response) use ($myPDO){
	if(!isset($_SESSION["session_login"])){
		return $response->withRedirect('/login', 301);
	}
  $tasks = getUserTasks($_SESSION['session_user_id'], $myPDO);
  $arr = ['tasks' => $tasks];
	return $this->get('renderer')->render($response, 'users/tasks.php', $arr);
});
$app->post('/tasks', function ($request, $response) use ($myPDO) {

  $text = $request->getParsedBodyParam('text');
  $status = $request->getParsedBodyParam('status');
  $user_id = $_SESSION["session_user_id"];
  $taskId = addTasks($text, $user_id, $status, $myPDO);
	$data = ['task_id' => $taskId[0], 'user_id' => $user_id];
	return $response->withJson($data);

});

$app->patch('/tasks/{id}', function ($request, $response, array $args) use ($myPDO) {
  $id = $args['id'];
  $user_id = $_SESSION["session_user_id"];
  $text = $request->getParsedBodyParam('text');
  $status = $request->getParsedBodyParam('status');

  $data = editTask($id, $user_id, $text, $status, $myPDO);
  return $response->withJson($data);
});

$app->delete('/tasks/{id}', function ($request, $response, array $args) use ($myPDO) {
  $id = $args['id'];
  $user_id = $_SESSION["session_user_id"];

  $data = deleteTask($id, $user_id, $myPDO);
  return $response->withJson($data);
});

//////////////// admin 
$app->get('/admin', function ($request, $response) use ($myPDO) {
	if(!isset($_SESSION["session_login"])){
		return $response->withRedirect('/login', 301);
	}
	if($_SESSION['session_user_status'] != 'admin'){
		return $response->write("access denied, back to <a href='/'>homepage</a>");
	}		
    $users = getAllUsers($myPDO);
    $arr = ['users' => $users];
    return $this->get('renderer')->render($response, 'admin/admin.php', $arr);
});

$app->get('/admin/tasks', function ($request, $response) use ($myPDO) {
	if(!isset($_SESSION["session_login"])){
		return $response->withRedirect('/login', 301);
	}
	if($_SESSION['session_user_status'] != 'admin'){
		return $response->write("access denied, back to <a href='/'>homepage</a>");
	}		

    return $this->get('renderer')->render($response, 'admin/user-tasks.php');
});

$app->delete('/admin/{id}', function ($request, $response, array $args) use ($myPDO) {

	$userId = $args['id'];
	
	$result = deleteUser($userId, $myPDO);
	if(!$result){
		return $response->write("Error deleting user");
	}

	return $response->withRedirect('/admin', 301);

});
$app->patch('/admin/{id}', function ($request, $response, array $args) use ($myPDO) {

	$userId = $args['id'];
	
	$result = changeStatus($userId, $myPDO);
	if(!$result){
		return $response->write("Error changing status");
	}

	return $response->withRedirect('/admin', 301);


});


$app->run();
