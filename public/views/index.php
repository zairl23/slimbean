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
             <a class="navbar-brand" href="#">生产管理系统</a>
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
                      <?php if($order['status'] >= 0) : ?>
                           <?php echo "<button id='edit' name='edit' class='btn btn-danger'>订单已生成</button>";?>
                       <?php endif; ?>
                      <?php foreach ($processes as $process) : ?>
                       <?php if($endId > $process['id']) : ?>
                               <?php foreach ($order->ownOrderlogList as $log) :?>
                                   <?php if($log['process_id'] == $process['id'] && $log['is_waibao'] == 0) :?>
                                      <?php echo "<button id='edit' name='edit' class='btn btn-danger'>{$process['name']}已完成</button>";?>
                                    <?php elseif($log['process_id'] == $process['id'] && $log['is_waibao'] == 1 && $log['is_completed'] == 1) :?>
                                        <?php echo "<button id='edit' name='edit' class='btn btn-success'>发外运行中</button>";?>
                                    <?php elseif($log['process_id'] == $process['id'] && $log['is_waibao'] == 1 && $log['is_completed'] == 2) :?>
                                        <?php echo "<button id='edit' name='edit' class='btn btn-danger'>发外已完成</button>";?>
                                   <?php endif;?>
                               <?php endforeach;?>
                       <?php elseif(($endId == $process['id']) && $is_waibao) : ?>
                             <?php foreach ($order->ownOrderlogList as $log) :?>
                                <?php if($log['process_id'] == $process['id'] && $log['is_waibao'] != 1) :?>
                                    <?php if($log['is_completed'] == 2) :?>
                                        <?php echo "<button id='edit' name='edit' class='btn btn-danger'>{$process['name']}已完成</button>";?>
                                    <?php elseif($log['is_completed'] == 1) :?>
                                        <?php echo "<button id='edit' name='edit' class='btn btn-success'>{$process['name']}运行中</button>";?>
                                    <?php endif;?>
                              <?php endif;?>
                             <?php endforeach;?>
                      <?php endif;?>
                      <?php if($process['id'] == $endId && $endLog['is_completed'] == 2) :?>
                                    <?php if($is_waibao) :?>
                                       <?php echo "<button id='edit' name='edit' class='btn btn-danger'>发外已完成</button>";?>
                                    <?php else:?>
                                        <?php echo "<button id='edit' name='edit' class='btn btn-danger'>{$process['name']}已完成</button>";?>
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
               </tr>
               <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./public/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./public/js/bootstrap.min.js"></script>
  </body>
</html>