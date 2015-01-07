<?php
/*
|--------------------------------------------------------------------------
| 辅助函数集合
|--------------------------------------------------------------------------
|
| Description
| @author neychang
| @touch  2014年12月13日14:59:30
*/
#=======================================================================
# 菜单激活显示
# @author neychang
# @touch  2015年1月3日10:54:51
#=======================================================================
$menuShow = function ($menuName){
	
	$orderActive = '';
	$userActive = '';
	$processActive = '';
	$roleActive = '';
	$gongxuActive = '';
	
	switch ($menuName) {
		case 'order':
			$orderActive = 'active';
			break;
		case 'user':
			$userActive = 'active';
			break;
		case 'process':
			$processActive = 'active';
			break;
		case 'role':
			$roleActive = 'active';
			break;
		case 'gongxu':
			$gongxuActive = 'active';
			break;
	}

	return compact('orderActive', 'userActive', 'processActive', 'roleActive', 'gongxuActive');
};
