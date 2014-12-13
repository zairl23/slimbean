<?php
/*
|--------------------------------------------------------------------------
| Manage for manager
|--------------------------------------------------------------------------
|
| Description
| @author neychang
| @touch  2014年12月13日14:59:30
*/
// $app->group('/admin', function () use ($app) {
	// 后台首页
	$app->get('/admin', $authCheck(), function() use ($app) {
		$orders = R::find('order');
		// $orderLog = R::findOne('orderlog', 'ORDER BY created_at DESC LIMIT 1');
		$processes = R::find('process');
		$orderActive = 'active';
		$userActive = '';
		$processActive = '';
		$app->render('/admin/index.php', compact('orders','processes','orderActive', 'userActive', 'processActive'));
	})->name('adminIndex');

	$app->get('/admin/addOrder', $authCheck(), function() use ($app) {
		$postUrl = $app->urlFor('postAddOrder');
		$orderActive = 'active';
		$userActive = '';
		$processActive = '';
		$app->render('/admin/orders/add.php', compact('postUrl', 'orderActive', 'userActive', 'processActive'));
	})->name('addOrder');

	$app->post('/admin/postOrder', $authCheck(), function() use ($app) {
		$order = R::dispense('order');
		$order->name = $app->request->post('name');
		$order->costumer_name = $app->request->post('costumer_name');
		$order->order_number = $app->request->post('order_number');
		$order->created_at = time();
		$order->updated_at = time();
		$order_id = R::store($order);
		$order_new = R::load('order', $order_id);
		$order_new->qrcode_path = '/special/showOrder/' . $order_id;
		R::store($order_new);
		$app->redirect($app->urlFor('adminIndex'));
	})->name('postAddOrder');

	$app->get('/admin/editOrder/:id', $authCheck(), function($id) use ($app) {
		$order = R::load( 'order', $id);
		$postUrl = $app->urlFor('postEditOrder', array('id' => $id));
		$orderActive = 'active';
		$userActive = '';
		$processActive = '';
		$adminUrl = $app->urlFor('adminIndex');
		$app->render('/admin/orders/edit.php', compact('order', 'postUrl', 'orderActive', 'userActive', 'processActive','adminUrl'));
	})->name('editOrder');

	$app->post('/admin/postEditOrder/:id', $authCheck(), function($id) use ($app) {
		$order = R::load( 'order', $id);
		$order->name = $app->request->post('name');
		$order->costumer_name = $app->request->post('costumer_name');
		$order->order_number = $app->request->post('order_number');
		$order->updated_at = time();
		R::store($order);
		$app->redirect($app->urlFor('adminIndex'));
	})->name('postEditOrder');

	$app->get('/admin/deleteOrder/:id',$authCheck(), function ($id) use ($app) {
		$order = R::load( 'order', $id);
		R::trash($order);
		$app->redirect($app->urlFor('adminIndex'));
	});

	// create Qrcode for one order
	$app->get('/admin/createOrderQrcode/:id', $authCheck(), function ($id) use ($app){
		// process qrcode genereate
		$qrCode = new \Endroid\QrCode\QrCode;
		$qrCode->setText("Life is too short to be generating QR codes");
		$qrCode->setSize(300);
		$qrCode->setPadding(10);
		$qrCode->render();
	});

	$app->get('/admin/users',$authCheck(), function() use ($app) {
		$users = R::find('user');
		$processes = R::find('process');
		$orderActive = '';
		$userActive = 'active';
		$processActive = '';
		$app->render('/admin/users/index.php', compact('users','processes','orderActive','userActive','processActive'));
	})->name('usersIndex');

	$app->get('/admin/addUser', $authCheck(), function() use ($app) {
		$postUrl = $app->urlFor('postUser');
		$processObj = R::find('process');
		// covert to array
		$processes  = array();
		foreach ($processObj as $process) {
			array_push($processes, array(
				'id' => $process->id,
				'name' => $process->name,
			));
		}
		array_push($processes, 
			array('id' => 'admin', 'name' => '管理员'), 
			array('id' => 'rudan', 'name' => '入单')
		);
		array_push($processes,
			array('id' => 'waibao', 'name' => '发外')
		);
		// var_dump($processes);exit;
		$orderActive = '';
		$userActive = 'active';
		$processActive = '';
		$app->render('/admin/users/add.php', compact('postUrl','processes','orderActive', 'userActive', 'processActive'));
	})->name('addUser');

	$app->post('/admin/postUser',$authCheck(), function() use ($app) {
		$user = R::dispense('user');
		$user->name = $app->request->post('name');
		$user->password = $app->request->post('password');
		$process_id = $app->request->post('process_id');
		if($process_id == 'admin'){
			$user->process_id = 0;
			$user->type = 1;
		}elseif($process_id == 'rudan'){
			$user->process_id = 0;
			$user->type = 2;
		}elseif($process_id == 'waibao'){
			$user->process_id = 0;
			$user->type = 3;
		}else{
			$user->process_id = $process_id;
		}
		R::store($user);
		$app->redirect($app->urlFor('usersIndex'));
	})->name('postUser');

	$app->get('/admin/editUser/:id', $authCheck(), function($id) use ($app) {
			$user = R::load( 'user', $id);
			$postUrl = $app->urlFor('postEditUser', array('id' => $id));
			$processObj = R::find('process');
			// covert to array
			$processes  = array();
			foreach ($processObj as $process) {
				array_push($processes, array(
					'id' => $process->id,
					'name' => $process->name,
				));
			}
			array_push($processes, 
				array('id' => 'admin', 'name' => '管理员'), 
				array('id' => 'rudan', 'name' => '入单')
			);
			array_push($processes,
				array('id' => 'waibao', 'name' => '外包')
			);
			$orderActive = '';
			$userActive = 'active';
			$processActive = '';
			$app->render('/admin/users/edit.php', compact('user', 'postUrl', 'processes','orderActive','userActive','processActive'));
		})->name('editUser');

	$app->post('/admin/postEditUser/:id',$authCheck(), function($id) use ($app) {
		$user = R::load( 'user', $id);
		$user->name = $app->request->post('name');
		$user->password = $app->request->post('password');
		$process_id = $app->request->post('process_id');
		if($process_id == 'admin'){
			$user->process_id = 0;
			$user->type = 1;
		}elseif($process_id == 'rudan'){
			$user->process_id = 0;
			$user->type = 2;
		}elseif($process_id == 'waibao'){
			$user->process_id = 0;
			$user->type = 3;
		}else{
			$user->process_id = $process_id;
		}
		R::store($user);
		$app->redirect($app->urlFor('usersIndex'));
	})->name('postEditUser');

	$app->get('/admin/deleteUser/:id',$authCheck(), function ($id) use ($app) {
		$user = R::load( 'user', $id);
		R::trash($user);
		$app->redirect($app->urlFor('usersIndex'));
	});

	$app->get('/admin/processes',$authCheck(), function() use ($app) {
		$processes = R::find('process');
		$orderActive = '';
		$userActive = '';
		$processActive = 'active';
		$app->render('/admin/processes/index.php', compact('processes','orderActive', 'userActive','processActive'));
	})->name('processesIndex');

	$app->get('/admin/addProcess', $authCheck(), function() use ($app) {
		$postUrl = $app->urlFor('postProcess');
		$processes = R::find('process');
		$orderActive = '';
		$userActive = '';
		$processActive = 'active';
		$app->render('/admin/processes/add.php', compact('postUrl','processes','orderActive', 'userActive','processActive'));
	})->name('addProcess');

	$app->post('/admin/postProcess', $authCheck(), function() use ($app) {
		$process = R::dispense('process');
		$process->name = $app->request->post('name');
		R::store($process);
		$app->redirect($app->urlFor('processesIndex'));
	})->name('postProcess');

	$app->get('/admin/editProcess/:id',$authCheck(), function($id) use ($app) {
			$process = R::load( 'process', $id);
			$postUrl = $app->urlFor('postEditProcess', array('id' => $id));
			$orderActive = '';
			$userActive = '';
			$processActive = 'active';
			$app->render('/admin/processes/edit.php', compact('process', 'postUrl', 'orderActive','userActive', 'processActive'));
		})->name('editProcess');

	$app->post('/admin/postEditProcess/:id', $authCheck(), function($id) use ($app) {
		$process = R::load( 'process', $id);
		$process->name = $app->request->post('name');
		R::store($process);
		$app->redirect($app->urlFor('processesIndex'));
	})->name('postEditProcess');

	$app->get('/admin/deleteProcess/:id', $authCheck(), function ($id) use ($app) {
		$process = R::load( 'process', $id);
		R::trash($process);
		$app->redirect($app->urlFor('processesIndex'));
	});
