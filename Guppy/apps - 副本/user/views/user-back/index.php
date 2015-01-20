<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="../Css/style.css" />
    <script type="text/javascript" src="../Js/jquery.js"></script>
    <script type="text/javascript" src="../Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="../Js/bootstrap.js"></script>
    <script type="text/javascript" src="../Js/ckform.js"></script>
    <script type="text/javascript" src="../Js/common.js"></script>

    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }
    </style>
</head>
<body>
    <?php
      $usersInfo = $_SESSION["usersInfo"];

      echo "usersInfo : ".print_r($usersInfo);
      echo "<br>";

    ?>
<form class="form-inline definewidth m20" action="/faeva.com/user/UserManage/findByQueryName" method="get">
    用户名称：
    <input type="text" name="name" id="username"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">新增用户</button>
</form>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th>用户id</th>
        <th>用户名称</th>
        <th>真实姓名</th>
        <th>最后登录时间</th>
        <th>角色</th>
        <th>操作</th>
    </tr>
    </thead>
    <?php
        $users = json_decode($usersInfo, true);
        foreach($users as $user){
          $id = $user['_id']['$id'];
          $name = $user["name"];
          $appId = $_SESSION['appId'];
          $strs = "";

          foreach($user["apps"] as $app){
            if($app['appId'] === $appId){
              foreach($app['roles'] as $role){
                $strs .= $role;
                $strs .= ";";
              }
              $strs = substr($strs, 0, strlen($strs)-1);
            }
          }
          echo "<tr>";
          echo "<td>$id</td>";
          echo "<td>$name</td>";
          echo "<td>$name</td>";
          echo "<td></td>";
          echo "<td>$strs</td>";
          echo "<td>";
          echo "<a href="."/faeva.com/user/UserManage/edit/$id".">编辑</a> | ";
          echo "<a href="."/faeva.com/user/UserManage/delete/$id".">删除</a>";
          echo "</td>";
        }
    ?>
	     <!-- <tr>
            <td>2</td>
            <td>admin</td>
            <td>管理员</td>
            <td></td>
            <td>
                <a href="edit.html">编辑</a> |
                <a href="">删除</a>
            </td>
        </tr> -->
</table>
</body>
</html>
<script>
    $(function () {
  		$('#addnew').click(function(){
  				window.location.href="add.html";
  		 });
    });

	function del(id)
	{
		if(confirm("确定要删除吗？"))
		{
			var url = "index.html";
			window.location.href=url;
		}
	}
</script>
