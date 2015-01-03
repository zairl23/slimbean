<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>生产管理系统</title>

    <!-- Bootstrap -->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/main.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="../publ../html5shiv.min.js"></script>
      <script src="../publ../respond.min.js"></script>
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
              <a class="navbar-brand" href="../">后台管理</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION['user_id'])) :?>
                    <?php echo "<li><a href='#'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
                    <?php echo "<li><a href='../logout'>退出</a></li>";?>
                <?php else :?>
                    <?php echo "<li><a href='#'>登陆</a></li>";?>
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
                <?php include __DIR__ . '/../../sidebar.php';?>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <h1 class="page-header">员工列表</h1>
                  <a title="增加员工" href="./addUser"><span class="glyphicon glyphicon-plus"></span></a>
                <!-- <h2 class="sub-header">Section title</h2> -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>姓名</th>
                                <th>工序(修改过渡显示)</th>
                                <th>岗位</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo $user['name']; ?></td>
                                <td>
                                    <?php if($user['type'] == 1) : ?>
                                            <?php echo "管理员"; ?>
                                    <?php elseif($user['type'] == 2) : ?>
                                        <?php echo "入单"; ?>
                                    <?php else: ?>
                                        <?php foreach ($processes as $process) : ?>
                                            <?php if($user['process_id'] == $process['id']) : ?>
                                                <?php echo $process['name'];?>
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                               </td>
                               <td>
                                   <?php foreach ($roles as $role) : ?>
                                       <?php if($user['role_id'] == $role['id']) : ?>
                                           <?php echo $role['name'];?>
                                       <?php endif ?>
                                   <?php endforeach; ?>
                               </td>
                               <td>
                                    <a id="edit" href=<?php echo "./editUser/" . $user['id']; ?> name="edit" class="btn btn-success">编辑</a>
                                    <a id="deleteUser" onClick="if(confirm('您确定删除此条消息么?')) {window.location='./deleteUser/'+ <?php echo $user['id']; ?>;} else {return false;}" name="删除" class="btn btn-danger">删除</a>
                               </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__.'/../../footer.php';?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../publ../jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../publ../bootstrap.min.js"></script>
  </body>
</html>