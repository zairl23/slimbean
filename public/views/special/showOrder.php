<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>执行流程</title>

	<!-- Bootstrap -->
	<link href="../../public/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
		  /*min-height: 2000px;*/
		  padding-top: 100px;
		}
		.center{
			text-align:center;
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
		   <!-- <div class="navbar-header">
			 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			   <span class="sr-only">Toggle navigation</span>
			   <span class="icon-bar"></span>
			   <span class="icon-bar"></span>
			   <span class="icon-bar"></span>
			 </button> -->
			<!-- <a class="navbar-brand" href="../../">生产管理系统</a> -->

		   <!-- </div> -->
		   <div id="navbar" class="">
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
			 <!-- <ul class="nav navbar-nav navbar-right"> -->
			<ul class="nav navbar-nav">
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
			   <!-- <li><a href="../navbar/">Default</a></li>
			   <li><a href="../navbar-static-top/">Static top</a></li>
			   <li class="active"><a href="./">Fixed top</a></li> -->
			 </ul>
		   </div><!--/.nav-collapse -->
		 </div>
	   </nav>


	<div class="jumbotron center">
		<h1><?php echo $order['name'];?></h1>
		<div id="scan"></div>
	</div>

	<?php include __DIR__.'/../footer.php';?>

	<script src="../../public/js/paper.min.js"></script>
	<script src="../../public/js/react.js"></script>
	<script src="../../public/js/JSXTransformer.js"></script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../../public/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../../public/js/bootstrap.min.js"></script>
	<script type="text/jsx" src="../../public/js/scan.js"></script>
	<script type="text/jsx">
		React.render(<Scan url="/order/set/<?php echo $order['id']; ?>" />, document.getElementById('scan'));
	</script>
  </body>
</html>