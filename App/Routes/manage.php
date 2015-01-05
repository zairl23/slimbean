<?php
/*
|--------------------------------------------------------------------------
| 超级管理后台
|--------------------------------------------------------------------------
|
| Description
| @author neychang
| @touch  2014年12月13日14:59:30
*/
// $app->group('/admin', function () use ($app) {
	// 后台首页
#=======================================================================
# 订单管理接口 --Order--订单
# @author neychang
# @touch  2015年1月3日13:19:04
#=======================================================================
	$app->get('/admin', $authCheck(), function() use ($app, $menuShow) {
		$orders = R::find('order');
		// $orderLog = R::findOne('orderlog', 'ORDER BY created_at DESC LIMIT 1');
		$processes = R::find('process');
		$menus = $menuShow('order');
		$app->render('/admin/index.php', compact('orders','processes','menus'));
	})->name('adminIndex');

	$app->get('/admin/addOrder', $authCheck(), function() use ($app, $menuShow) {
		$postUrl = $app->urlFor('postAddOrder');
		$menus = $menuShow('order');
		$app->render('/admin/orders/add.php', compact('postUrl', 'menus'));
	})->name('addOrder');

	$app->post('/admin/postOrder', $authCheck(), function() use ($app) {
		$order = R::dispense('order');
		$order->name = $app->request->post('name');
		$order->costumer_name = $app->request->post('costumer_name');
		$order->order_number = $app->request->post('order_number');
		$order->is_completed = 1;
		$order->created_at = time();
		$order->updated_at = time();
		$order_id = R::store($order);
		$order_new = R::load('order', $order_id);
		$order_new->qrcode_path = '/special/showOrder/' . $order_id;
		R::store($order_new);

		$record = R::dispense('record');
		$record->order_id = $order_id;
		$record->connect_id = 39;
		$record->created_at = time();
		$record->ended_at = 0;
		R::store($record);
		unset($record);
		$record = R::dispense('record');
		$record->order_id = $order_id;
		$record->connect_id = 2;
		$record->created_at = time();
		$record->ended_at = 0;
		R::store($record);
		unset($record);
		$record = R::dispense('record');
		$record->order_id = $order_id;
		$record->connect_id = 3;
		$record->created_at = time();
		$record->ended_at = 0;
		R::store($record);

		$app->redirect($app->urlFor('adminIndex'));
	})->name('postAddOrder');

	$app->get('/admin/editOrder/:id', $authCheck(), function($id) use ($app, $menuShow) {
		$order = R::load( 'order', $id);
		$postUrl = $app->urlFor('postEditOrder', array('id' => $id));
		$menus = $menuShow('order');
		$adminUrl = $app->urlFor('adminIndex');
		$app->render('/admin/orders/edit.php', compact('order', 'postUrl', 'menus'));
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

#=======================================================================
# 员工管理接口 --User--员工
# @author neychang
# @touch  2015年1月3日13:10:12
#=======================================================================
	$app->get('/admin/users',$authCheck(), function() use ($app, $menuShow) {
		$users = R::find('user');
		$processes = R::find('process');
		$roles = R::find('role');
		$menus = $menuShow('user');
		// not show admin
		foreach ($users as $id => $user) {
			if($user['type'] == 1){
				unset($users[$id]);
			}
		}

		$app->render('/admin/users/index.php', compact('users','roles','processes','menus'));
	})->name('usersIndex');

	$app->get('/admin/addUser', $authCheck(), function() use ($app, $menuShow) {
		$postUrl = $app->urlFor('postUser');
		// $processes = array();
		// $fawais = array();
		// $processes = R::getAll('SELECT * FROM process');

		// array_push($processes, 
		// 	array('id' => 'admin', 'name' => '管理员'), 
		// 	array('id' => 'rudan', 'name' => '入单')
		// );
		$roles = R::getAll('SELECT * FROM role');
		$menus = $menuShow('user');
		$app->render('/admin/users/add.php', compact('postUrl','roles','menus'));
	})->name('addUser');

	$app->post('/admin/postUser',$authCheck(), function() use ($app) {
		$user = R::dispense('user');
		$user->name = $app->request->post('name');
		$user->password = $app->request->post('password');
		// $process_id = $app->request->post('process_id');
		// if($process_id == 'admin'){
		// 	$user->process_id = 0;
		// 	$user->type = 1;
		// }elseif($process_id == 'rudan'){
		// 	$user->process_id = 0;
		// 	$user->type = 2;
		// }else{
		// 	$process = R::load('process', $process_id);
		// 	if($process->type == 1) $user->type = 3;
		// 	else $user->type = 0;
		// 	$user->process_id = $process_id;
		// }
		$user->role_id = $app->request->post('role_id');
		R::store($user);
		$app->redirect($app->urlFor('usersIndex'));
	})->name('postUser');

	$app->get('/admin/editUser/:id', $authCheck(), function($id) use ($app, $menuShow) {
			$user = R::load( 'user', $id);
			$postUrl = $app->urlFor('postEditUser', array('id' => $id));
			$roles = R::getAll('SELECT * FROM role');
			// $processes = array();
			// $fawais = array();
			// $processes = R::getAll('SELECT * FROM process');
			// array_push($processes, 
			// 	array('id' => 'admin', 'name' => '管理员'), 
			// 	array('id' => 'rudan', 'name' => '入单')
			// );

			$menus = $menuShow('user');
			$app->render('/admin/users/edit.php', compact('user', 'postUrl', 'roles','menus'));
		})->name('editUser');

	$app->post('/admin/postEditUser/:id',$authCheck(), function($id) use ($app) {
		$user = R::load( 'user', $id);
		$user->name = $app->request->post('name');
		$user->password = $app->request->post('password');
		$user->role_id = $app->request->post('role_id');
		// $process_id = $app->request->post('process_id');
		// if($process_id == 'admin'){
		// 	$user->process_id = 0;
		// 	$user->type = 1;
		// }elseif($process_id == 'rudan'){
		// 	$user->process_id = 0;
		// 	$user->type = 2;
		// }else{
		// 	$process = R::load('process', $process_id);
		// 	if($process->type == 1) $user->type = 3;
		// 	else $user->type = 0;
		// 	$user->process_id = $process_id;
		// }
		R::store($user);
		$app->redirect($app->urlFor('usersIndex'));
	})->name('postEditUser');

	$app->get('/admin/deleteUser/:id',$authCheck(), function ($id) use ($app) {
		$user = R::load( 'user', $id);
		R::trash($user);
		$app->redirect($app->urlFor('usersIndex'));
	});

#=======================================================================
# 后台管理接口--Process--工序
# @author neychang
# @touch  2015年1月3日10:52:41
#=======================================================================
	$app->get('/admin/processes',$authCheck(), function() use ($app, $menuShow) {
		$processes = R::getAll('SELECT * FROM process WHERE `type`=0');
		$menus = $menuShow('process');
		$app->render('/admin/processes/index.php', compact('processes', 'menus'));
	})->name('processesIndex');

	$app->get('/admin/addProcess', $authCheck(), function() use ($app, $menuShow) {
		$postUrl = $app->urlFor('postProcess');
		$processes = R::find('process');
		$menus = $menuShow('process');
		$app->render('/admin/processes/add.php', compact('postUrl','processes','menus'));
	})->name('addProcess');

	$app->post('/admin/postProcess', $authCheck(), function() use ($app) {
		$process = R::dispense('process');
		$process->name = $app->request->post('name');
		$pid = R::store($process);
		unset($process);
		$process = R::dispense('process');
		$process->name = $app->request->post('name') . '发外';
		$process->pid = $pid;
		$process->type = 1;
		R::store($process);
		$app->redirect($app->urlFor('processesIndex'));
	})->name('postProcess');

	$app->get('/admin/editProcess/:id',$authCheck(), function($id) use ($app, $menuShow) {
		$process = R::load( 'process', $id);
		$postUrl = $app->urlFor('postEditProcess', array('id' => $id));
		$menus = $menuShow('process');
		$app->render('/admin/processes/edit.php', compact('process', 'postUrl', 'menus'));
	})->name('editProcess');

	$app->post('/admin/postEditProcess/:id', $authCheck(), function($id) use ($app) {
		$process = R::load( 'process', $id);
		$process->name = $app->request->post('name');
		R::store($process);
		$process_fawai = R::findOne('process', ' pid = ?', array($id));
		$process_fawai->name = $app->request->post('name') . '发外';
		R::store($process_fawai);
		$app->redirect($app->urlFor('processesIndex'));
	})->name('postEditProcess');

	$app->get('/admin/deleteProcess/:id', $authCheck(), function ($id) use ($app) {
		$process = R::load( 'process', $id);
		R::trash($process);
		$app->redirect($app->urlFor('processesIndex'));
	});

#=======================================================================
# 后台管理接口--Role--岗位
# @author neychang
# @touch  2015年1月3日10:52:41
#=======================================================================
	$app->get('/admin/roles',$authCheck(), function() use ($app, $menuShow) {
		$roles = R::getAll('SELECT * FROM role');
		$menus = $menuShow('role');
		$app->render('/admin/roles/index.php', compact('roles','menus'));
	})->name('rolesIndex');
	$app->get('/admin/addRole', $authCheck(), function() use ($app, $menuShow) {
		$postUrl = $app->urlFor('postRole');
		$menus = $menuShow('role');
		$app->render('/admin/roles/add.php', compact('postUrl','menus'));
	})->name('addRole');

	$app->post('/admin/postRole', $authCheck(), function() use ($app) {
		$role = R::dispense('role');
		$role->name = $app->request->post('name');
		$rid = R::store($role);
		$app->redirect($app->urlFor('rolesIndex'));
	})->name('postRole');

	$app->get('/admin/editRole/:id',$authCheck(), function($id) use ($app, $menuShow) {
		$role = R::load( 'role', $id);
		$postUrl = $app->urlFor('postEditRole', array('id' => $id));
		$menus = $menuShow('role');
		$app->render('/admin/roles/edit.php', compact('role', 'postUrl','menus'));
	})->name('editRole');

	$app->post('/admin/postEditRole/:id', $authCheck(), function($id) use ($app) {
		$role = R::load('role', $id);
		$role->name = $app->request->post('name');
		R::store($role);
		$app->redirect($app->urlFor('rolesIndex'));
	})->name('postEditRole');


	$app->get('/admin/deleteRole/:id', $authCheck(), function ($id) use ($app) {
		$role = R::load( 'role', $id);
		R::trash($role);
		$app->redirect($app->urlFor('rolesIndex'));
	});
