<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>生产管理系统</title>

    <!-- Bootstrap -->
    <link href="./public/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="./public/js/html5shiv.min.js"></script>
      <script src="./public/js/respond.min.js"></script>
    <![endif]-->
  <style type="text/css">
     body {
       padding-top: 40px;
       padding-bottom: 40px;
       background-color: #f5f5f5;
     }

     .form-signin {
       max-width: 300px;
       padding: 19px 29px 29px;
       margin: 0 auto 20px;
       background-color: #fff;
       border: 1px solid #e5e5e5;
       -webkit-border-radius: 5px;
          -moz-border-radius: 5px;
               border-radius: 5px;
       -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
          -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
               box-shadow: 0 1px 2px rgba(0,0,0,.05);
     }
     .form-signin .form-signin-heading,
     .form-signin .checkbox {
       margin-bottom: 10px;
     }
     .form-signin input[type="text"],
     .form-signin input[type="password"] {
       font-size: 16px;
       height: auto;
       margin-bottom: 15px;
       padding: 7px 9px;
     }

   </style>
  </head>
  <body>
    <div class="container">
          <form class="form-signin" method="post" action="<?php echo $postUrl;?>">
            <h2 class="form-signin-heading">登陆</h2>
            <input type="text" name="name" class="input-block-level" placeholder="姓名">
            <input type="password" name="password" class="input-block-level" placeholder="密码">
            <!-- <label class="checkbox">
              <input type="checkbox" value="remember-me"> Remember me
            </label> -->
            <button class="btn btn-primary" type="submit">登陆</button>
          </form>

    </div>
 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./public/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./public/js/bootstrap.min.js"></script>
  </body>
</html>