<?php
/*
|--------------------------------------------------------------------------
| Change the order's status
|--------------------------------------------------------------------------
|
| Description
| @author neychang
| @touch  2014年12月13日14:57:05
*/
$app->get('/special/showOrder/:id', $loginCheck(), function ($id) use ($app){
	$process_id = $_SESSION['process_id'];
	$order    = R::load('order', $id);
	if(!$order->id) exit;
	$orderLog = array();
	if($_SESSION['type'] == 0){
		$orderLog = R::getAll( 'SELECT * FROM orderlog WHERE process_id = :process_id AND order_id = :order_id AND is_waibao = 0',
	        array(':process_id' => $process_id, ':order_id' => $id));
	}elseif($_SESSION['type'] == 3) {
		$orderLog = R::getAll( 'SELECT * FROM orderlog WHERE process_id = :process_id AND order_id = :order_id AND is_waibao = 1',
	        array(':process_id' => $order->status, ':order_id' => $id));
	}
	if(count($orderLog) == 0) {
		if(($order['status'] + 1) != $process_id && $_SESSION['type'] !=3){
			$word = '';
			$getUrl  = '#';
		}else{
			$word = '开始';
			$getUrl  = $app->urlFor('updateOrder', array('id' => $id)) . '?s=start&p=' . $order['status'];
		}
	}elseif(count($orderLog) == 1) {
		if($orderLog[0]['is_completed'] == 2) {
			$word = '';
			$getUrl  = '#';
		}else{
			$word = '结束';
			$getUrl  = $app->urlFor('updateOrder', array('id' => $id)) . '?s=stop&d=' . $orderLog[0]['id'];
		}
	}
	if($_SESSION['type'] == 1 || $_SESSION['type'] == 2) {
		$getUrl='#';
		$word = '开始';
	}
	// $orderLog = R::find('orderLogs', 'order_id = :order_id', array(':order_id' => $id));
	$app->render('/special/show.php', compact('order','orderLogs', 'getUrl', 'word'));
})->name('showOrder');

$app->get('/special/updateOrder/:id', $loginCheck(),function($id) use ($app){
	$order = R::load('order', $id);
	$process_id = $_SESSION['process_id'];
	if($_SESSION['type'] != 3 && ($order->status > $process_id)){
		eixt;
	}
	$s = $app->request->get('s');// start or stop
	$p = $app->request->get('p');// now process
	$order = R::load('order', $id);
	// $orderLog = R::getAll( 'SELECT * FROM orderLogs WHERE process_id = :process_id AND order_id = :order_id AND is_waibao = 0',
 //        array(':process_id' => $process_id, ':order_id' => $id));
    // var_dump(count($orderLog));exit;
	//开始生产
	if($s == 'start'){
		$orderLog = R::dispense('orderlog');
		$order->updated_at = time();
		$orderLog->order_id = $id;
		$orderLog->created_at = time();
		$orderLog->is_completed = 1;
		if($_SESSION['type'] == 3) {
			$orderLog->is_waibao = 1;
			$orderLog->process_id = $p;
		}else{
			$orderLog->process_id = $process_id;
			$order->status = $process_id;
		}
		R::store($order);
		R::store($orderLog);
		$app->redirect($app->urlFor('showOrder', array('id' => $id)));
	}//完成生产
	elseif($s == 'stop'){
		$log =  R::load('orderlog', $app->request->get('d'));
		$order->updated_at = time();
		$log->is_completed = 2;
		R::store($order);
		R::store($log);
		$app->redirect($app->urlFor('showOrder', array('id' => $id)));
	}
})->name('updateOrder');

// create Qcode for one order
// $app->get('/normal/createOrderQrcode/:id', $authCheck(), function ($id) use ($app){
// 	$imgPath = "public/images/" .$id. ".png";
// 	$qrCode = new \Endroid\QrCode\QrCode;
// 	$text = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
// 	$qrCode->setText($text);
// 	// $this->setPath(__DIR__.'/assets/data');
// 	// $this->setImagePath(__DIR__.'/assets/image');
// 	$qrCode->setSize(300);
// 	$qrCode->setPadding(10);
// 	$myfile = fopen($imgPath, "w") or die("Unable to open file!");
// 	fclose($myfile);
// 	$qrCode->render($imgPath);
// 	$order = R::load('orders', $id);
// 	$order->qrcode_path = $imgPath;
// 	R::store($order);
// 	// $app->render('/special/show.php', compact('imgPath'));
// 	$app->redirect($app->urlFor('normalIndex'));
// });

// show one order and process start or not in mobile phone's browser
$app->get('/special/showOrder/:id', function($id) use ($app){
	echo "show order information";
});