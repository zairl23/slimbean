<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>生产管理系统</title>

	<!-- Bootstrap -->
	<link href="../public/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
		  min-height: 2000px;
		  padding-top: 70px;
		}
		#react-content{
			height: 1000px;
		}
		#myCanvas{
			height: 1000px;
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
	<?php include 'header.php';?>

	<div id="order-processing"></div>

	<?php include 'footer.php';?>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../public/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../public/js/bootstrap.min.js"></script>
	<script src="../public/js/paper.min.js"></script>
	<script src="../public/js/react.js"></script>
	<script src="../public/js/JSXTransformer.js"></script>
	<script type="text/jsx" src="../public/js/process.js"></script>
  </body>
</html>