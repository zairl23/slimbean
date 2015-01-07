<ul class="nav nav-sidebar">
    <li><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'];?>>前台首页</a></li>
    <!-- <li><a href="#">Reports</a></li>
    <li><a href="#">Analytics</a></li>
    <li><a href="#">Export</a></li> -->
</ul>

<ul class="nav nav-sidebar">
    <li class="<?php echo $menus['orderActive'];?>"><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin>";?>订单列表</a></li>
    <!-- <li><a href="#">Reports</a></li>
    <li><a href="#">Analytics</a></li>
    <li><a href="#">Export</a></li> -->
</ul>
<ul class="nav nav-sidebar">
    <li class="<?php echo $menus['roleActive'];?>"><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/roles>";?>岗位列表</a></li>
   <!--  <li><a href="">One more nav</a></li>
    <li><a href="">Another nav item</a></li> -->
</ul>
<ul class="nav nav-sidebar">
    <li class="<?php echo $menus['userActive'];?>"><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/users>";?>员工列表</a></li>
    <!-- <li><a href="">Nav item again</a></li>
    <li><a href="">One more nav</a></li>
    <li><a href="">Another nav item</a></li>
    <li><a href="">More navigation</a></li> -->
</ul>
<!-- <ul class="nav nav-sidebar"> -->
    <!-- <li class="<?php echo $menus['processActive'];?>"><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/processes>";?>工序列表</a></li> -->
   <!--  <li><a href="">One more nav</a></li>
    <li><a href="">Another nav item</a></li> -->
<!-- </ul> -->
<ul class="nav nav-sidebar">
    <li class="<?php echo $menus['gongxuActive'];?>"><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/gongxus>";?>工序列表</a></li>
   <!--  <li><a href="">One more nav</a></li>
    <li><a href="">Another nav item</a></li> -->
</ul>