<?php 
/*
|--------------------------------------------------------------------------
| Filters for route control
|--------------------------------------------------------------------------
|
| Description
| @author neychang
| @touch  2014年12月13日15:01:23
*/
// check filter
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
