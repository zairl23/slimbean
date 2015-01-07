<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv=Refresh content="5">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>生产管理系统</title>

	<!-- Bootstrap -->
	<link href="./public/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
		  min-height: 2000px;
		  padding-top: 70px;
		}
	</style>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="./public/js/html5shiv.min.js"></script>
	  <script src="./public/js/respond.min.js"></script>
	<![endif]-->
  </head>
  <body>
	<!-- Fixed navbar -->
	   <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		 <div class="container">
		   <div class="navbar-header">
			 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			   <span class="sr-only">Toggle navigation</span>
			   <span class="icon-bar"></span>
			   <span class="icon-bar"></span>
			   <span class="icon-bar"></span>
			 </button>
			 <a class="navbar-brand" href="#">湖北新达泰印刷有限公司生产管理系统</a>
		   </div>
		   <div id="navbar" class="navbar-collapse collapse">
			 <!-- <ul class="nav navbar-nav">
			   <li class="active"><a href="#">Home</a></li>
			   <li><a href="#about">About</a></li>
			   <li><a href="#contact">Contact</a></li>
			   <li class="dropdown">
				 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
				 <ul class="dropdown-menu" role="menu">
				   <li><a href="#">Action</a></li>
				   <li><a href="#">Another action</a></li>
				   <li><a href="#">Something else here</a></li>
				   <li class="divider"></li>
				   <li class="dropdown-header">Nav header</li>
				   <li><a href="#">Separated link</a></li>
				   <li><a href="#">One more separated link</a></li>
				 </ul>
			   </li>
			 </ul> -->
			 <ul class="nav navbar-nav navbar-right">
				 <?php if(isset($_SESSION['user_id'])) :?>
					<?php if($_SESSION['type'] == 1) : ?>
					   <?php echo "<li><a href='./admin'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
					<?php elseif($_SESSION['type'] == 2) : ?>
						<?php echo "<li><a href='./normal'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
					<?php else :?>
						<?php echo "<li><a href='#'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
					<?php endif;?>
				  <?php echo "<li><a href='./logout'>退出</a></li>";?>
				 <?php else :?>
					 <?php echo "<li><a href='./login'>登陆</a></li>";?>
				 <?php endif; ?>
			   <!-- <li><a href="../navbar/">Default</a></li>
			   <li><a href="../navbar-static-top/">Static top</a></li>
			   <li class="active"><a href="./">Fixed top</a></li> -->
			 </ul>
		   </div><!--/.nav-collapse -->
		 </div>
	   </nav>

	<div class="container">
	<!-- <h1>生产管理系统</h1>
	<a class="btn" href="#"><i class="icon-home"></i>登陆</a> -->
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>生产单号</th>
					<th>品名</th>
					<!-- <th>客户</th> -->
					<th>生产状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach ($orders as $order) : ?>
			   <tr>
				   <td><?php echo $order['order_number']; ?></td>
				   <td><?php echo $order['name']; ?></td>
				   <!-- <td><?php echo $order['costumer_name']; ?></td> -->
				   <?php $endLog = end($order->ownOrderlogList); ?>
				   <?php $endId = $endLog['process_id'];?>
				   <?php $is_waibao = $endLog['is_waibao'];?>
				   <td>
				   		<?php if($order->desc) :?>
				   			<?php echo "<button class='btn btn-success'>" . $order->desc . "</button>";?>
				   		<?php else :?>
				   			<?php echo "<button class='btn btn-danger'>订单已生成<br>" . date('Y-m-d H:i:s', $order['created_at']) . "</button>";?>
						<?php endif;?>
				   </td>
				   <td>
					 <a id="scanOrder" href=<?php echo "./special/showQrcode/" .  $order['id'];?> class="btn btn-primary">扫描</a>
				   </td>
				    <td>
				   	 <a id="showOrder" href=<?php echo "./show/" .  $order['id'];?> class="btn btn-primary">进度</a>
				    </td>
			   </tr>
			   <?php endforeach; ?>
			</tbody>
		</table>

	<?php include 'footer.php';?>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="./public/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="./public/js/bootstrap.min.js"></script>
  </body>
</html>