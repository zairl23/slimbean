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
$app = new \Slim\Slim(array('templates.path' => __DIR__ . '/public/views'));


// load routes
foreach(glob(ROOT . '/App/Routes/*.php') as $router) {
	include_once $router;
}

$app->get('/test', function() use ($app){
	$app->render('react.html');
});

$app->get('/api/orders', function() use ($app){
	$orders = R::getAll('SELECT * FROM `order`');
	echo json_encode($orders);
});

// // 首页
$app->get('/', function() use ($app) {
	$orders = R::find('order');
	foreach ($orders as $key => $value) {
		$record = end($value->ownRecordList);
		if($record) {
			$orders[$key]['desc'] = R::load('connect', $record->connect_id)->desc;
		}
	}
	// $processes = R::find('process');
	// $order->ownOrderlogList;
	// $orderLog = R::findOne('orderlog', 'ORDER BY created_at DESC LIMIT 1');
	$app->render('index.php', compact('orders', 'orderLog'));
	exit;
})->name('index');

$app->run();

