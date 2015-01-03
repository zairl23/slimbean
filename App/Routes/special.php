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

/**
 *取得当前工序名
 *
 * @param  obj $order
 * @author neychang
 * @return string
 * @touch  2014年12月30日11:43:06
 */
$nowProccess = function($order){
	//取得类型ID
	return R::load('process', $order->status)->name;
};


/**
 *取得下一道工序的ID
 *
 * @param  obj $order
 * @param  integer user_type
 * @author neychang
 * @touch  2014年12月15日13:29:01
 */
$nextProcessId = function($order, $user_type){
	//取得类型ID
	$process_list = R::load('type', $order->order_type)->process_ids;
	$process_list = explode(',', $process_list);

	foreach ($process_list as $key => $process) {
		if($process == $order->status){
			if($user_type == 0) {
				return $process_list[$key+1];
			}elseif($user_type == 3) {
				return R::findOne('process', ' pid=?', array($order->status))->id;
				// return $process_list[$key+1];
			}
		}
	}
};

$app->get('/tete', function() use($app, $nowProccess){
	$order = R::load('order', 2);
	var_dump($nowProccess($order));
});

/**
 * 创建二维码
 *
 * @param  integer $id order's Id
 * @return string  view
 * @author neychang
 * @touch  2014年12月14日16:22:48
 */
$creatQrcode = function($id, $app){
	$imgPath = "public/images/" .$id. ".png";
	if(!file_exists($imgPath)){
		$qrCode = new \Endroid\QrCode\QrCode;
		// $text = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$text = 'http://' . $_SERVER['SERVER_NAME'] . $app->urlFor('showOrder',array('id' => $id));
		$qrCode->setText($text);
		$qrCode->setSize(300);
		$qrCode->setPadding(10);
		$myfile = fopen($imgPath, "w") or die("Unable to open file!");
		fclose($myfile);
		$qrCode->render($imgPath);
	}	
};

$app->get('/special/showOrder/:id', $loginCheck(), function ($id) use ($app, $nextProcessId, $nowProccess){
	$process_id = $_SESSION['process_id'];
	$order    = R::load('order', $id);
	$nowProccess = $nowProccess($order); 
	// var_dump($nowProccess);exit;
	if(!$order->id) exit;
	$orderLog = array();
	if($_SESSION['type'] == 0){
		$orderLog = R::getAll( 'SELECT * FROM orderlog WHERE process_id = :process_id AND order_id = :order_id AND is_waibao = 0',
	        array(':process_id' => $process_id, ':order_id' => $id));
	}elseif($_SESSION['type'] == 3) {
		$pid = R::findOne('process', ' id=?', array($process_id))->pid;
		$orderLog = R::getAll( 'SELECT * FROM orderlog WHERE process_id = :process_id AND order_id = :order_id AND is_waibao = 1',
	        array(':process_id' => $pid, ':order_id' => $id));
	}
	if(count($orderLog) == 0) {
		// if(($order['status'] + 1) != $process_id && $_SESSION['type'] !=3){
		// if(($order['status'] + 1) != $process_id){
		if($_SESSION['type'] == 0){
			if(($nextProcessId($order,  0) == $process_id) && ($order->is_completed ==1)){
				$word = '开始';
				$getUrl  = $app->urlFor('updateOrder', array('id' => $id)) . '?s=start&p=' . $order['status'];
			}else{
				$word = '';
				$getUrl  = '#';
			}
		}elseif($_SESSION['type'] == 3){
			if($nextProcessId($order,  3) == $process_id){
				$word = '开始';
				$getUrl  = $app->urlFor('updateOrder', array('id' => $id)) . '?s=start&p=' . $order['status'];
				// $getUrl  = $app->urlFor('updateOrder', array('id' => $id)) . '?s=start&p=' . $process_id;
			}else{
				$word = '';
				$getUrl  = '#';
			}
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
	$app->render('/special/showOrder.php', compact('order','orderLogs', 'getUrl', 'word', 'nowProccess'));
})->name('showOrder');

$app->get('/special/updateOrder/:id', $loginCheck(),function($id) use ($app){
	$order = R::load('order', $id);
	$process_id = $_SESSION['process_id'];
	// if($_SESSION['type'] != 3 && ($order->status > $process_id)){
	// 	eixt;
	// }
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
		$order->is_completed = 0;
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
		$order->is_completed = 1;
		$log->is_completed = 2;
		R::store($order);
		R::store($log);
		$app->redirect($app->urlFor('showOrder', array('id' => $id)));
	}
})->name('updateOrder');

/**
 * 显示二维码的视图
 *
 * @param  integer $id order's Id
 * @return string  view
 * @author neychang
 * @touch  2014年12月14日16:22:48
 */
$app->get('/special/showQrcode/:id', $loginCheck(), function($id) use($app, $creatQrcode){
	$creatQrcode($id, $app);
	$order_id = $id;
	$order = R::load('order', $id);
	$app->render('/special/showQrcode.php', compact('order_id', 'order'));
})->name('showQrcode');


// show one order and process start or not in mobile phone's browser
$app->get('/special/showOrder/:id', function($id) use ($app){
	echo "show order information";
});

/**
 * 打印二维码视图
 *
 * @param  integer $id order's Id
 * @return string  view
 * @author neychang
 * @touch  2014年12月22日15:24:24
 */
$app->get('/special/printQrcode/:id', $loginCheck(), function($id) use($app, $creatQrcode){
	$creatQrcode($id, $app);
	$order_id = $id;
	$order = R::load('order', $id);
	$app->render('/special/printQrcode.php', compact('order_id', 'order'));
})->name('printQrcode');


// show one order and process start or not in mobile phone's browser
$app->get('/special/showOrder/:id', function($id) use ($app){
	echo "show order information";
});
