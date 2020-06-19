<?php
$myPDO = new PDO('sqlite:tasks.db');
require_once("lib.php");

use Slim\Factory\AppFactory;
use DI\Container;
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
$message = 'init';

$app->get('/', function ($request, $response) {
	if(!isset($_SESSION["session_login"])){
		return $response->withRedirect('/login', 301);
	} else {
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
	$user_id = login($myPDO, $login, $password);
	if(!$user_id){
		$this->get('flash')->addMessage('warning', $message);
		return $response->withRedirect('/login', 301);
	}

	$_SESSION["session_login"] = $login;
	$_SESSION["session_user_id"] = $user_id;
	return $response->withRedirect('/tasks', 301);	
});
$app->get('/logout', function ($request, $response) {

	unset($_SESSION['session_login']);
	unset($_SESSION['session_user_id']);
	session_destroy();
	
    return $response->withRedirect('/login', 301);	
});
$app->get('/tasks', function ($request, $response) {
	if(!isset($_SESSION["session_login"])){
		return $response->withRedirect('/login', 301);
	}
	return $this->get('renderer')->render($response, 'users/tasks.php');
});
$app->run();
