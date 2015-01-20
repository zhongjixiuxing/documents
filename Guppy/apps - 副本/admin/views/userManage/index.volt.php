<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../css/admin/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../../css/admin/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="../../css/admins/style.css" />
    <script type="text/javascript" src="../../js/admin/jquery.js"></script>
    <script type="text/javascript" src="../../js/admin/jquery.sorted.js"></script>
    <script type="text/javascript" src="../../js/admin/bootstrap.js"></script>
    <script type="text/javascript" src="../../js/admin/ckform.js"></script>
    <script type="text/javascript" src="../../js/admin/common.js"></script>

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

<form class="form-inline definewidth m20" action="/Faeva/admin/UserManage/index" method="get">
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

    <?php foreach ($users as $user) { ?>
        <tr>
        <td><?php echo $user->_id; ?></td>
        <td><?php echo $user->name; ?></td>
        <td><?php echo $user->name; ?></td>
        <td></td>
        <td><?php foreach ($user->apps as $app) { ?><?php foreach ($app['roles'] as $role) { ?><?php echo $role; ?><?php echo ';'; ?><?php } ?><?php } ?></td>
        <td>
      <a href="/Faeva/admin/UserManage/edit/<?php echo $user->_id; ?>">编辑</a> |
        <a href="/Faeva/admin/UserManage/delete/<?php echo $user->_id; ?>">删除</a>
      </td>
    <?php } ?>

</table>
</body>
</html>
<script>
    $(function () {
  		$('#addnew').click(function(){
  				window.location.href="/Faeva/admin/userManage/add";
  		 });
    });

	function del(id)
	{
		if(confirm("确定要删除吗？"))
		{
			var url = "/Faeva/admin/userManage/delete/"+id;
			window.location.href=url;
		}
	}
</script>
