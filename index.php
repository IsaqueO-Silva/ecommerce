<?php 

session_start();

require_once('vendor/autoload.php');

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

$app = new Slim();

$app->config('debug', true);

require_once('functions.php');
require_once('site.php');
require_once('admin.php');
require_once('admin-users.php');
require_once('admin-categories.php');
require_once('admin-products.php');

/* Product - CRUD */
$app->get('/admin/categories', function() {

	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl('categories', array(
		'categories'	=> $categories
	));
});

$app->get('/admin/categories/create', function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('categories-create');
});

$app->get('/admin/categories/:idcategory/delete', function($idcategory) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: /admin/categories');
	exit;
});

$app->get('/admin/categories/:idcategory', function($idcategory) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl('categories-update', array(
		'category'	=> $category->getValues()
	));
});

$app->post('/admin/categories/create', function() {

	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;
});

$app->post('/admin/categories/:idcategory', function($idcategory) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;
});

$app->get('/categories/:idcategory', function($idcategory) {

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl('category', array(
		'category'	=> $category->getValues(),
		'products'	=> array()
	));
});

$app->run();

?>