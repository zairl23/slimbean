<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>生产管理系统</title>

	<!-- Bootstrap -->
	<link href="./public/css/bootstrap.min.css" rel="stylesheet">
	<link href="./public/css/main.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="./public/js/html5shiv.min.js"></script>
	  <script src="./public/js/respond.min.js"></script>
	<![endif]-->
  </head>
  <body>
	<!-- <div class="container-fluid"> -->

	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="./">后台管理</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
			  <ul class="nav navbar-nav navbar-right">
				<?php if(isset($_SESSION['user_id'])) :?>
					<?php echo "<li><a href='#'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
					<?php echo "<li><a href='./logout'>退出</a></li>";?>
				<?php else :?>
					<?php echo "<li><a href='./login'>登陆</a></li>";?>
				<?php endif; ?>
			   <!--  <li><a href="#">Dashboard</a></li>
				<li><a href="#">Settings</a></li>
				<li><a href="#">Profile</a></li>
				<li><a href="#">Help</a></li> -->
			  </ul>
			  <!-- <form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search...">
			  </form> -->
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<!-- <div class="row"> -->
			<div class="col-sm-3 col-md-2 sidebar">
				<?php include __DIR__ . '/../sidebar.php';?>
			</div>

			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div class="row">
					<h1 class="page-header">订单列表</h1>
					<a title="增加订单" href="./admin/addOrder"><span class="glyphicon glyphicon-plus"></span></a>

				<!-- <h2 class="sub-header">Section title</h2> -->
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<!-- <th>测试</th> -->
								<th>生产单号</th>
								<th>品名</th>
								<th>客户</th>
								<th>生产状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($orders as $order) : ?>
							<tr>
								<td><?php echo $order['order_number']; ?></td>
								<td><?php echo $order['name']; ?></td>
								<td><?php echo $order['costumer_name']; ?></td>
								<?php $endLog = end($order->ownOrderlogList); ?>
								<?php $endId = $endLog['process_id'];?>
								 <?php $is_waibao = $endLog['is_waibao'];?>
								<td>
									<?php if($order['status'] >= 0) : ?>
										<?php echo "<button id='edit' name='edit' class='btn btn-danger'>订单已生成<br>" . date('Y-m-d H:i:s', $order['created_at']) . "</button>";?>
									<?php endif; ?>
									<?php foreach ($processes as $process) : ?>
					   <?php if($endId > $process['id']) : ?>
							   <?php foreach ($order->ownOrderlogList as $log) :?>
								   <?php if($log['process_id'] == $process['id'] && $log['is_waibao'] == 0) :?>
									  <?php echo "<button id='edit' name='edit' class='btn btn-danger'>{$process['name']}已完成<br>" . date('Y-m-d H:i:s', $log['created_at']) . "</button>";?>
									<?php elseif($log['process_id'] == $process['id'] && $log['is_waibao'] == 1 && $log['is_completed'] == 1) :?>
										<?php echo "<button id='edit' name='edit' class='btn btn-success'>发外运行中</button>";?>
									<?php elseif($log['process_id'] == $process['id'] && $log['is_waibao'] == 1 && $log['is_completed'] == 2) :?>
										<?php echo "<button id='edit' name='edit' class='btn btn-danger'>发外已完成<br>" . date('Y-m-d H:i:s', $log['created_at']) . "</button>";?>
								   <?php endif;?>
							   <?php endforeach;?>
					   <?php elseif(($endId == $process['id']) && $is_waibao) : ?>
							 <?php foreach ($order->ownOrderlogList as $log) :?>
								<?php if($log['process_id'] == $process['id'] && $log['is_waibao'] != 1) :?>
									<?php if($log['is_completed'] == 2) :?>
										<?php echo "<button id='edit' name='edit' class='btn btn-danger'>{$process['name']}已完成<br>" . date('Y-m-d H:i:s', $log['created_at']) . "</button>";?>
									<?php elseif($log['is_completed'] == 1) :?>
										<?php echo "<button id='edit' name='edit' class='btn btn-success'>{$process['name']}运行中</button>";?>
									<?php endif;?>
							  <?php endif;?>
							 <?php endforeach;?>
					  <?php endif;?>
					  <?php if($process['id'] == $endId && $endLog['is_completed'] == 2) :?>
									<?php if($is_waibao) :?>
									   <?php echo "<button id='edit' name='edit' class='btn btn-danger'>发外已完成<br>" . date('Y-m-d H:i:s', $endLog['created_at']) . "</button>";?>
									<?php else:?>
										<?php echo "<button id='edit' name='edit' class='btn btn-danger'>{$process['name']}已完成<br>" . date('Y-m-d H:i:s', $endLog['created_at']) . "</button>";?>
								   <?php endif;?>
					   <?php elseif($process['id'] == $endId && $endLog['is_completed'] == 1) :?>
							  <?php if($is_waibao) :?>
								 <?php echo "<button id='edit' name='edit' class='btn btn-success'>发外运行中</button>";?>
							  <?php else:?>
								  <?php echo "<button id='edit' name='edit' class='btn btn-success'>{$process['name']}运行中</button>";?>
							  <?php endif;?>
					   <?php endif;?>
					<?php endforeach;?>
								</td>
								<td>
									<!-- <a id="edit" href=<?php echo "./admin/createOrderQrcode/" . $order['id']; ?> name="edit" class="btn btn-success">生成二维码</a> -->
									<a id="edit" href=<?php echo "./admin/editOrder/" . $order['id']; ?> name="edit" class="btn btn-success">编辑</a>
									<a id="deleteOrder" onClick="if(confirm('您确定删除此条消息么?')) {window.location='./admin/deleteOrder/'+ <?php echo $order['id']; ?>;} else {return false;}" name="删除" class="btn btn-danger">删除</a>
									<a id="scanOrder" href=<?php echo "./special/printQrcode/" .  $order['id'];?> class="btn btn-primary">打印</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<?php include __DIR__.'/../footer.php';?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="./public/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="./public/js/bootstrap.min.js"></script>
  </body>
</html>