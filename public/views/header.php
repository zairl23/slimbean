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
		 <a class='navbar-brand' href=http://<?php echo $_SERVER['HTTP_HOST'];?>>湖北新达泰印刷有限公司生产管理系统</a>
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
				   <?php echo "<li><a href=http://" . $_SERVER['HTTP_HOST'] . "/admin>你好！" . $_SESSION['user_name'] . "</a></li>";?>
				<?php elseif($_SESSION['type'] == 2) : ?>
					<?php echo "<li><a href='./normal'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
				<?php else :?>
					<?php echo "<li><a href='#'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
				<?php endif;?>
			 <?php echo "<li><a href=http://" . $_SERVER['HTTP_HOST'] . "/logout>退出</a></li>";?>
			 <?php else :?>
				 <?php echo "<li><a href=http://" . $_SERVER['HTTP_HOST'] . "/login>登陆</a></li>";?>
			 <?php endif; ?>
		   <!-- <li><a href="../navbar/">Default</a></li>
		   <li><a href="../navbar-static-top/">Static top</a></li>
		   <li class="active"><a href="./">Fixed top</a></li> -->
		 </ul>
	   </div><!--/.nav-collapse -->
	 </div>
   </nav>
