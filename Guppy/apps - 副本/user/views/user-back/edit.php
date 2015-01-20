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
    $userInfo = $_GET["userInfo"];
    $appId = $_SESSION['appId'];

    $user = json_decode($userInfo, true);
    echo "userInfo : $userInfo<br>";
  ?>

<form action="/faeva.com/user/userManage/update" method="post" class="definewidth m20">
<input type="hidden" name="id" value="<?php echo $user['_id']['$id']; ?>" />
    <table class="table table-bordered table-hover definewidth m10">
        <tr>
            <td width="10%" class="tableleft">登录名</td>
            <td><input type="text" name="name" value="<?php echo $user['name'];?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">密码</td>
            <td><input type="password" name="pw" value="<?php echo $user['pw']; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">真实姓名</td>
            <td><input type="text" name="realname" value="<?php echo $user['name']?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">邮箱</td>
            <td><input type="text" name="email" value="<?php echo $user['email']?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">状态</td>
            <td>

                <input type="radio" name="status" value="0"
                    <eq name="user.status" value='1' <?php if($user['vstatus']) echo "checked"; ?>></eq> 启用
              <input type="radio" name="status" value="1"
                    <eq name="user.status" value='0' <?php if(!$user['vstatus']) echo "checked"; ?>></eq> 禁用
            </td>
        </tr>
        <tr>
            <td class="tableleft">角色</td>
            <td><input type="text" name="roles" value="<?php
                $roleStr = '';
                foreach($user['apps'] as $app){
                  if($app['appId'] === $appId){
                    foreach($app['roles'] as $role){
                      $roleStr .= $role;
                      $roleStr .= ';';
                    }
                  }
                }

                $roleStr = substr($roleStr, 0 , strlen($roleStr)-1);

                echo $roleStr;

              ?>"></td>
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
