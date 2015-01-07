<?php
/*
|--------------------------------------------------------------------------
| Api for client's js request (get and post operate)
|--------------------------------------------------------------------------
|
| Description
| @author neychang
| @touch  2015年1月7日16:20:35
*--------------------------------------------------------------------------
*/
/**
 * Show order's list
 *
 * @author neychang
 * @touch  2015年1月5日13:38:59
 * @return json {role_id: 1}
 */
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
	$records = R::getAll('SELECT connect_id, ended_at FROM record WHERE order_id = :order_id', array('order_id' => $id));
	
	foreach ($records as $key => $value) {
		$connect = R::load('connect', $value['connect_id']);
		$records[$key]['desc'] = $connect->desc;
	}
	
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
	// $role_id = 2;

	$operations = R::getAll('SELECT * FROM connect WHERE role_id = :role_id', array('role_id' => $role_id));

	// $records = R::getAll('SELECT connect_id FROM record WHERE order_id = :order_id', array('order_id' => $id));

	$setting = array();
	// var_dump($records);exit;
	foreach ($operations as $key => $operation) {
		$record = R::find('record', 'order_id = :order_id and connect_id = :connect_id', array('order_id' => $id, 'connect_id' => $operation['id']));
		// $connect = R::load('connect', $record['connect_id']);
		// var_dump($record);exit;
		$processName = $operation['desc'];
		$connect_id = $operation['id'];
		$to_id = $operation['follow_id'];
		
		if($record){
			$words = '已执行';
			$url = '#1';
		}else{
			$words = '执行';
			$url = '#0';
		}
		// var_dump($url);exit;
		array_push($setting, array(
			'words' => $words,
			'url'   => $url,
			'processName' => $processName,
			'connect_id'  => $connect_id,
			'order_id'    => $id,
			'to_id'       => $to_id,
		));
		
	}
	
	echo json_encode($setting);
});

/**
 * Process the record log
 * 
 * @return json {json: 1(0)}0--success or 1 failure
 * @author neychang
 * @touch  2015年1月6日14:52:08
 */
$app->post('/order/operate', function() use($app){
	$order_id = $app->request->post('order_id');
	$connect_id = $app->request->post('connect_id');
	$to_id = $app->request->post('to_id');
	// Determine whether the record contain logined user's to process
	$checkWhere = 'order_id = :order_id and to_id = :to_id';
	$check = R::find('record', $checkWhere, array('order_id' => $order_id, 'to_id' => $_SESSION['role_id']));
	if($check){
		foreach ($check as $key => $value) {
			if($value->ended_at == 0){
				$value->ended_at = time();
				R::store($value);
			}
		}
	}
	
	$record = R::dispense('record');
	$record->order_id = $order_id;
	$record->connect_id = $connect_id;
	$record->to_id = $to_id;
	$record->created_at = time();
	$record->ended_at  = 0;
	if(R::store($record)){
		echo json_encode(array('status' => 1));
	}else{
		echo json_decode(array('status' => 0));
	}
});