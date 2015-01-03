<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>生产管理系统|扫描</title>

	<!-- Bootstrap -->
	<link href="../../public/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
		  /*min-height: 2000px;*/
		  padding-top: 70px;
		}
	</style>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="../../public/js/html5shiv.min.js"></script>
	  <script src="../../public/js/respond.min.js"></script>
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
			 <a class="navbar-brand" href="../../">生产管理系统</a>
		   </div>
		   <div id="navbar" class="navbar-collapse collapse">
			 <ul class="nav navbar-nav navbar-right">
				 <?php if(isset($_SESSION['user_id'])) :?>
					<?php if($_SESSION['type'] == 1) :?>
						<?php echo "<li class='active'><a href='../../admin'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
					<?php elseif($_SESSION['type'] == 2) :?>
						<?php echo "<li class='active'><a href='../../normal'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
					<?php else:?>
						<?php echo "<li class='active'><a href='../../'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
					<?php endif;?>
						<?php echo "<li><a href='../../logout'>退出</a></li>";?>
				 <?php else :?>
					 <?php echo "<li><a href='../../login'>登陆</a></li>";?>
				 <?php endif; ?>
			 </ul>
		   </div><!--/.nav-collapse -->
		 </div>
	   </nav>

   <div class="container">

		<div class="jumbotron" style="text-align:center;">
			<span>湖北新达泰印刷有限公司</span>
			<br>
			<span>品名:<?php echo $order->name;?></span>
			<br>
			<span><?php echo "<img src=../../public/images/" . $order_id .".png />"; ?></span>
			<br>
			<span>——&nbsp;新思维&nbsp;新高度&nbsp;新达泰&nbsp;——</span>
		</div>

	  </div> <!-- /container -->


	<?php include __DIR__.'/../footer.php';?>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../../public/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../../public/js/bootstrap.min.js"></script>
  </body>
</html>