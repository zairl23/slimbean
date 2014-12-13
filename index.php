 <?php
require 'vendor/autoload.php';
require 'rb.php';
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
// check
$loginCheck = function() use ($app){
	return function () use ($app){
        if (!isset($_SESSION['authentificated']) || $_SESSION['authentificated'] !== true) {
            $app->flash('error', '请先登陆');
            //echo $backUrl = $app->request->getResourceUri();exit;
            if($backUrl = $app->request->getResourceUri()){
            	$app->redirect($app->urlFor('login') . '?backUrl=' . $backUrl);
            }
            $app->redirect($app->urlFor('login'));
        }
    };
};
// for admin
$authCheck = function () use ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['authentificated']) || $_SESSION['authentificated'] !== true) {
            $app->flash('error', '请先登陆');
            $app->redirect($app->urlFor('login'));
        }elseif (preg_match("/^\/admin/", $app->request->getResourceUri()) && $_SESSION['type'] != 1) {
            $app->redirect($app->urlFor('index'));
        }
    };
};
// for normal
$authCheckNoraml = function () use ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['authentificated']) || $_SESSION['authentificated'] !== true) {
            $app->flash('error', '请先登陆');
            $app->redirect($app->urlFor('login'));
        }elseif (preg_match("/^\/normal/", $app->request->getResourceUri()) && ($_SESSION['type'] != 2 && $_SESSION['type'] != 1)) {
            $app->redirect($app->urlFor('index'));
        }
    };
};

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

$app->get('/login', function() use ($app) {
	$backUrl = $app->request->get('backUrl');
	if($backUrl){
		$postUrl = $app->urlFor('postLogin') . '?backUrl=' . $backUrl;
	}else{
		$postUrl = $app->urlFor('postLogin');
	}
	$app->render('login.php', compact('postUrl'));
})->name('login');

$app->get('/logout',function() use ($app) {
	if(isset($_SESSION['authentificated']) && $_SESSION['authentificated'] === true){
		$_SESSION['authentificated'] = null;
		$_SESSION['user_id'] = null;
		$_SESSION['user_name'] = null;
		$_SESSION['process_id'] = null;
		$_SESSION['type'] = null;
		$app->redirect($app->urlFor('index'));
	}
})->name('logout');

$app->post('/postLogin', function() use ($app) {
	$authUser = $app->request->post('name');
	$authPass = $app->request->post('password');
	$check = R::findOne( 'user', ' name = ? ', array($authUser));
	if($check && $check->password == $authPass){
		$_SESSION['authentificated'] = true;
		$_SESSION['user_id'] = $check->id;
		$_SESSION['user_name'] = $check->name;
		$_SESSION['process_id'] = $check->process_id;
		$_SESSION['type'] = $check->type;
		if($backUrl = $app->request->get('backUrl')){
			$app->redirect($app->request->getRootUri() . $backUrl);
		}
		elseif($check->type == 1) $app->redirect('./admin');
		elseif($check->type == 2) $app->redirect('./normal');
		else{
			$app->redirect('./');
		}
	}else{
		$app->redirect('./login');
	}
})->name('postLogin');

// normal manage
$app->get('/normal', $authCheckNoraml(), function() use ($app) {
	$orders = R::find('order');
	$processes = R::find('process');
	// $orderLog = R::findOne('orderlog', 'ORDER BY created_at DESC LIMIT 1');
	$app->render('/normal/index.php', array('orders' => $orders,'processes' => $processes));
})->name('normalIndex');

$app->get('/normal/addOrder',$authCheckNoraml(), function() use ($app) {
	$app->render('/normal/add.php', array('postUrl' => $app->urlFor('postAddOrderNormal')));
})->name('addOrderNormal');

$app->post('/normal/postOrder', $authCheckNoraml(), function() use ($app) {
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
	$app->redirect($app->urlFor('normalIndex'));
})->name('postAddOrderNormal');

$app->get('/normal/editOrder/:id', $authCheckNoraml(), function($id) use ($app) {
	$order = R::load( 'order', $id);
	$postUrl = $app->urlFor('postEditOrderNormal', array('id' => $id));
	$app->render('/normal/edit.php', compact('order', 'postUrl'));
})->name('editOrderNormal');

$app->post('/normal/postEditOrder/:id', $authCheckNoraml(), function($id) use ($app) {
	$order = R::load( 'order', $id);
	$order->name = $app->request->post('name');
	$order->costumer_name = $app->request->post('costumer_name');
	$order->order_number = $app->request->post('order_number');
	$order->updated_at = time();
	R::store($order);
	$app->redirect($app->urlFor('normalIndex'));
})->name('postEditOrderNormal');

$app->get('/normal/deleteOrder/:id',$authCheckNoraml(), function ($id) use ($app) {
	$order = R::load('order', $id);
	R::trash($order);
	$app->redirect($app->urlFor('normalIndex'));
});

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

//admin
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

	// $app->get('/orders', function() use ($app) {
	// 	$orders = R::find('orders');
	// 	$processes = R::find('processes');
	// 	$app->render('admin/orders/index.php', compact('orders', 'processes'));
	// });

	// // 员工相关
	// $app->get('/users', function() use ($app) {
	// 	$app->render('admin/users/index.php');
	// });

	// // 工序相关
	// $app->get('/processes', function() use ($app) {
	// 	$app->render('admin/processes/index.php');
	// });
// });

$app->run();
?>
