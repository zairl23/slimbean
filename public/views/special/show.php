<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>生产管理系统</title>

    <!-- Bootstrap -->
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
          min-height: 2000px;
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
                     <?php echo "<li><a href='#'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
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

   <div class="container">
        <!-- <div class="header">
          <ul class="nav nav-pills pull-right" role="tablist">
            <li role="presentation" class="active"><a href="#">Home</a></li>
            <li role="presentation"><a href="#">About</a></li>
            <li role="presentation"><a href="#">Contact</a></li>
          </ul>
          <h3 class="text-muted">Project name</h3>
        </div> -->

        <div class="jumbotron" style="text-align:center;">
          <h1><?php echo $order['name'];?></h1>
          <p class="lead"></p>
          <?php if($_SESSION['process_id'] == 0 && ($_SESSION['type'] == 1 || $_SESSION['type'] == 2)) :?>
            <?php echo "<h1><a class='btn btn-lg btn-success' href='#' role='button'>" . $word . "</a></h1>";?>
          <?php elseif(!$word) : ?>
                <?php echo "<p></p>";?>
          <?php else :?>
            <?php echo "<h1><a class='btn btn-lg btn-success' href='" . $getUrl ."' role='button'>" . $word . "</a></h1>";?>
          <?php endif; ?>
        </div>

      <!--   <div class="row marketing">
          <div class="col-lg-6">
            <h4>Subheading</h4>
            <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

            <h4>Subheading</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

            <h4>Subheading</h4>
            <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
          </div>

          <div class="col-lg-6">
            <h4>Subheading</h4>
            <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

            <h4>Subheading</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

            <h4>Subheading</h4>
            <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
          </div>
        </div>

        <div class="footer">
          <p>&copy; Company 2014</p>
        </div> -->

      </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../public/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../public/js/bootstrap.min.js"></script>
  </body>
</html>