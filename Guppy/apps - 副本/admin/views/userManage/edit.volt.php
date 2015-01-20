<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/admin/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/admin/style.css" />
    <script type="text/javascript" src="../../../js/admin/jquery.js"></script>
    <script type="text/javascript" src="../../../js/admin/jquery.sorted.js"></script>
    <script type="text/javascript" src="../../../js/admin/bootstrap.js"></script>
    <script type="text/javascript" src="../../../js/admin/ckform.js"></script>
    <script type="text/javascript" src="../../../js/admin/common.js"></script>



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

<form action="/Faeva/admin/userManage/update" method="post" class="definewidth m20">
<input type="hidden" name="id" value="<?php echo $user->_id; ?>" />
    <table class="table table-bordered table-hover definewidth m10">
        <tr>
            <td width="10%" class="tableleft">登录名</td>
            <td><input type="text" name="name" value="<?php echo $user->name; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">密码</td>
            <td><input type="password" name="pw" value="<?php echo $user->pw; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">真实姓名</td>
            <td><input type="text" name="realname" value="<?php echo $user->name; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">邮箱</td>
            <td><input type="text" name="email" value="<?php echo $user->email; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">状态</td>
            <td>

                <input type="radio" name="status" value="0"
                    <eq name="user.status" value='1' <?php if ($user->vstatus == 1) { ?><?php echo 'checked'; ?><?php } ?>></eq> 启用
              <input type="radio" name="status" value="1"
                    <eq name="user.status" value='0' <?php if ($user->vstatus == 0) { ?><?php echo 'checked'; ?><?php } ?>></eq> 禁用
            </td>
        </tr>
        <tr>
            <td class="tableleft">角色</td>
            <td><input type="text" name="roles" value="<?php foreach ($user->apps as $app) { ?><?php foreach ($app['roles'] as $role) { ?><?php echo $role; ?><?php echo ';'; ?><?php } ?><?php } ?>
              "></td>
        </tr>
        <tr>
            <td class="tableleft"></td>
            <td>
                <button type="submit" class="btn btn-primary" type="button">保存</button>				 &nbsp;&nbsp;<button type="button" class="btn btn-success" name="backid" id="backid">返回列表</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<script>
    $(function () {
		$('#backid').click(function(){
				window.location.href="{:U('User/index')}";
		 });

    });
</script>
