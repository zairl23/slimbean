<?php
require 'vendor/autoload.php';
require 'rb.php';
define('ROOT', __DIR__);
ini_set('date.timezone', 'Asia/Shanghai');
//set up database connection
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.10.158'){
	R::setup('mysql:host=localhost;dbname=dockk','root','');
} else {
	R::setup('mysql:host=localhost;dbname=dockk','user','user123');
}
R::freeze(true);
// start session
session_start();

//slim
$app = new \Slim\Slim(array('templates.path' => __DIR__ . '/Api/views'));


// load routes
foreach(glob(ROOT . '/App/Api/*.php') as $router) {
	include_once $router;
}

// 首页
$app->get('/', function() use ($app) {
	// $orders = R::getAll('SELECT * FROM `order`');
	// $processes = R::getAll('SELECT * FROM process');
	// $app->response->headers->set('Content-Type', 'application/json');
	// $app->response->write(json_encode(array('orders' => $orders, 'processes' => $processes), true));
	$app->render('index.html');
})->name('index');

$app->get('/demo', function() use($app){
	$app->render('demo.html');
});

$app->run();
?>
