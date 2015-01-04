<?php
/*
|--------------------------------------------------------------------------
| 用户登陆注册接口
|--------------------------------------------------------------------------
|
| @autho neychang
| @touch 2015年1月3日13:28:31
*/
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
		$_SESSION['role_id'] = null;
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
		$_SESSION['role_id'] = $check->role_id;
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
