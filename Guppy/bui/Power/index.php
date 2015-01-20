<?php
    require_once "/config/config.php";
?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../Css/bootstrap.css" />
<link rel="stylesheet" type="text/css"
	href="../Css/bootstrap-responsive.css" />
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

@media ( max-width : 980px) {
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

  权限管理
  <br>
  <?php
      $power = $_SESSION['power'];
      $jsonStr = json_encode($power);
      $power = json_decode($jsonStr, true);

  ?>
	<form class="form-inline definewidth m20" action="/faeva.com/user/power/findByQueryName"
		method="get">
		角色名称： <input type="text" name="powername" id="powername"
			class="abc input-default" placeholder="" value="">&nbsp;&nbsp;
		<button type="submit" class="btn btn-primary">查询</button>
		&nbsp;&nbsp;
		<button type="button" class="btn btn-success" id="addnew">新增权限</button>
	</form>
	<table class="table table-bordered table-hover definewidth m10">
		<thead>
			<tr>
				<th>角色id</th>
				<th>角色名称</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
    <tbody>
      <?php
        echo "<br>power : ".print_r($power);
          foreach($power['powers'] as $pow){
            $pid = $pow['pid'];
            $name = $pow['name'];
            echo "<ul>";
            echo "<ul>";

              echo "<li>name: ".$name;
              echo "　　　<a href='/faeva.com/user/power/delete/$pid'> delete</a> | ";
              echo "<a href='/faeva.com/user/power/edit/$pid'> edit</a><br>";

              echo "<li>pid : ".$pid."<br>";
              echo "<li>controller : ".$pow['controller']."<br>";

              echo "<li>options : <br>";

              echo "<ul>";
              foreach($pow['options'] as $option){
                $oid = $option['oid'];
                echo "<li>oid : ".$oid;

                echo "　　　<a href='/faeva.com/user/power/deleteOption/$pid/$oid'> delete</a> | ";
                echo "<a href='/faeva.com/user/power/editOption/$pid/$oid'> edit</a> | ";
                echo "<a href='/faeva.com/user/power/addOption/$pid'> add</a><br>";

                echo "<li>name : ".$option['name']."<br>";
                echo "<li>action : ".$option['action']."<br>";
                echo "<br>";
              }
              echo "</ul>";
            echo "</ul>";
            echo "</ul>";
          }



          // foreach ($roles as $role){
          //   $id = $role["_id"]['$id'];
          //   $name = $role["name"];
          //   $status = $role["status"];
          //
          //   echo "<tr><td>$id</td>";
          //   echo "<td>$name</td>";
          //   echo "<td>$status</td>";
          //   echo "<td>
          //     <a href="."/faeva.com/user/role/findById/$id".">编辑</a> | ".
          //     "<a href="."/faeva.com/user/role/delete?name=$name".">删除</a></td>	</tr>";
          // }
      ?>
    </tbody>
	</table>
</body>
</html>


<script>
	$(function() {
		$('#addnew').click(function() {
			window.location.href = "/faeva.com/user/power/add";
		});

	});

	function del(id) {

		if (confirm("确定要删除吗？")) {

			var url = "index.html";
			window.location.href = url;

		}

	}
</script>
