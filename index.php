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
	$processes = R::find('process');
	// $order->ownOrderlogList;
	// $orderLog = R::findOne('orderlog', 'ORDER BY created_at DESC LIMIT 1');
	$app->render('index.php', compact('orders', 'processes', 'orderLog'));
	exit;
})->name('index');

// test show 
$app->get('/show/:id', function($id) use($app){
	$order = R::load('order', $id);
	$roles = R::find('role');
	$order_id = $id;
	// var_dump(compact('order', 'roles'));exit;
	$app->render('show.php', compact('order', 'roles', 'order_id'));
	exit;
});

/**
 * Watch order's status
 *
 * @author neychang
 * @touch  2015年1月5日13:38:59
 * @return json {role_id: 1}
 */
$app->get('/order/watch/:id', function($id) use($app){
	$order = R::load('order', $id);
	$records = R::getAll('SELECT connect_id FROM record WHERE order_id = :order_id', array('order_id' => $id));
	echo json_encode($records);
});

/**
 * Setting order's operation
 *
 * @author neychang
 * @touch  2015年1月5日13:47:13
 * @return json {role_id: 1}
 */
$app->get('/order/set/:id', $loginCheck, function($id) use($app){
	$order = R::load('order', $id);
	$orderName = $order->name;

	$role_id = $_SESSION['role_id'];
	$role_id = 2;

	$records = R::getAll('SELECT connect_id FROM record WHERE order_id = :order_id', array('order_id' => $id));

	$setting = array();
	// var_dump($records);exit;
	foreach ($records as $key => $record) {

		$connect = R::load('connect', $record['connect_id']);
		// var_dump($connect->role_id);exit;
		if($connect && ($role_id == $connect->role_id)){
			$processName = $connect->desc;
			$words = '执行';
			$url = '#1';
		}else{
			$processName = $connect->desc;
			$words = '无操作';
			$url = '#0';
		}
		// var_dump($url);exit;
		array_push($setting, array(
			'words' => $words,
			'url'   => $url,
			'processName' => $processName,
		));
		
	}
	// var_dump($setting);exit;
	echo json_encode($setting);
});

$app->run();

