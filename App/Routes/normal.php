<?php
/*
|--------------------------------------------------------------------------
|  Normal manage for normal user
|--------------------------------------------------------------------------
|
| Description
| @author neychang
| @touch  2014年12月13日14:52:19
*/
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
	$order->is_completed = 1;
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