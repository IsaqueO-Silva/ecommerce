<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

/* Admin - Login */
$app->get('/admin', function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('index');
});

$app->get('/admin/login', function() {

	$page = new PageAdmin([
		'header'	=> false,
		'footer'	=> false
	]);

	$page->setTpl('login');
});

$app->post('/admin/login', function() {

	User::login($_POST['login'], $_POST['password']);

	header('Location: /admin');
	exit;
});

$app->get('/admin/logout', function() {

	User::logout();

	header('Location: /admin/login');
	exit;
});

/* Forgot password */
$app->get('/admin/forgot', function() {

	$page = new PageAdmin([
		'header'	=> false,
		'footer'	=> false
	]);

	$page->setTpl('forgot');
});

$app->post('/admin/forgot', function() {

	$user = User::getForgot($_POST['email']);

	header('Location: /admin/forgot/sent');
	exit;
});

$app->get('/admin/forgot/sent', function() {

	$page = new PageAdmin([
		'header'	=> false,
		'footer'	=> false
	]);

	$page->setTpl('forgot-sent');
});

$app->get('/admin/forgot/reset', function() {

	/* Validando o código de recuperação de senha */
	$user = User::validForgotDecrypt($_GET['code']);

	$page = new PageAdmin([
		'header'	=> false,
		'footer'	=> false
	]);

	$page->setTpl('forgot-reset', array(
		'name'	=> $user['desperson'],
		'code'	=> $_GET['code']
	));
});

$app->post('/admin/forgot/reset', function() {

	/* Validando o código de recuperação de senha */
	$forgot = User::validForgotDecrypt($_POST['code']);

	User::setForgotUsed($forgot['idrecovery']);

	$user = new User();

	$user->get((int)$forgot['iduser']);

	$password = password_hash($_POST['password'], PASSWORD_BCRYPT, array(
		'cost'	=> 12
	));

	$user->setPassword($password);

	$page = new PageAdmin([
		'header'	=> false,
		'footer'	=> false
	]);

	$page->setTpl('forgot-reset-success');
});

?>