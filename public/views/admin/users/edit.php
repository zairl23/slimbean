<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>生产管理系统</title>

    <!-- Bootstrap -->
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../public/css/main.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="../../public/html5shiv.min.js"></script>
      <script src="../../public/respond.min.js"></script>
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
              <a class="navbar-brand" href="../../">后台管理</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
               <?php if(isset($_SESSION['user_id'])) :?>
                    <?php echo "<li><a href='#'>你好！" . $_SESSION['user_name'] . "</a></li>";?>
                    <?php echo "<li><a href='../../logout'>退出</a></li>";?>
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
                <ul class="nav nav-sidebar">
                    <li class="<?php echo $orderActive;?>"><a href="../../admin">订单列表</a></li>
                    <!-- <li><a href="#">Reports</a></li>
                    <li><a href="#">Analytics</a></li>
                    <li><a href="#">Export</a></li> -->
                </ul>
                <ul class="nav nav-sidebar">
                    <li class="<?php echo $userActive;?>"><a href="../../admin/users">员工列表</a></li>
                    <!-- <li><a href="">Nav item again</a></li>
                    <li><a href="">One more nav</a></li>
                    <li><a href="">Another nav item</a></li>
                    <li><a href="">More navigation</a></li> -->
                </ul>
                <ul class="nav nav-sidebar">
                    <li class="<?php echo $processActive;?>"><a href="../../admin/processes">工序列表</a></li>
                   <!--  <li><a href="">One more nav</a></li>
                    <li><a href="">Another nav item</a></li> -->
                </ul>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <!-- <h2 class="sub-header">Section title</h2> -->
                <form class="form-horizontal" method="post" action="<?php echo $postUrl; ?>">
                <fieldset>

                <!-- Form Name -->
                <legend>编辑员工</legend>

                <!-- Text input-->
                <div class="control-group">
                  <label class="control-label" for="name">姓名</label>
                  <div class="controls">
                    <input id="name" name="name" type="text" placeholder="姓名" class="input-xxlarge" required="" 
                    value="<?php echo $user['name'];?>">
                  </div>
                </div>

                <!-- Password input-->
                <div class="control-group">
                  <label class="control-label" for="password">密码</label>
                  <div class="controls">
                    <input name="password" type="input" placeholder="密码" class="input-xxlarge" required="" value="<?php echo $user['password'];?>">
                  </div>
                </div>

                <!-- Text input-->
                <div class="control-group">
                  <label class="control-label" for="process_id">岗位</label>
                  <div class="controls">
                    <select id="selectbasic" name="process_id" class="form-control">
                        <option value="0">请选择</option>
                        <?php foreach ($processes as $process) : ?>
                            <?php if($process['id'] == $user['process_id']) : ?>
                              <?php echo "<option selected='selected' value=". $process['id'] . ">" . $process['name'] . "</option>";?>
                              <?php elseif($process['id'] == 'admin' && $user['type'] == 1) : ?>
                                <?php echo "<option selected='selected' value=". $process['id'] . ">" . $process['name'] . "</option>";?>
                              <?php elseif($process['id'] == 'rudan' && $user['type'] == 2) : ?>
                                <?php echo "<option selected='selected' value=". $process['id'] . ">" . $process['name'] . "</option>";?>
                              <?php elseif($process['id'] == 'waibao' && $user['type'] == 3) : ?>
                                <?php echo "<option selected='selected' value=". $process['id'] . ">" . $process['name'] . "</option>";?>
                            <?php else : ?>
                                 <?php echo "<option value=". $process['id'] . ">" . $process['name'] . "</option>";?>
                            <?php endif;?>
                        <?php endforeach; ?>
                        <!-- <option value="">Option one</option>
                        <option value="2">Option two</option> -->
                    </select>
                    <!-- <input id="process_id" name="process_id" type="text" placeholder="岗位" class="input-xxlarge" required=""> -->

                  </div>
                </div>

                <!-- Button -->
                <div class="control-group">
                  <!-- <label class="control-label" for="singlebutton">Single Button</label> -->
                  <div class="controls">
                    <button id="singlebutton" name="singlebutton" class="btn btn-primary">保存</button>
                  </div>
                </div>

                </fieldset>
                </form>

            </div>
        </div>
    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../public/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../public/bootstrap.min.js"></script>
  </body>
</html>