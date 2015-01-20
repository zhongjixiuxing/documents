
<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../../css/admin/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="../../css/admin/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="../../css/admin/style.css" />
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

	<form class="form-inline definewidth m20" action="/Faeva/admin/power/findByQueryName"
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
		appId : {{session.appId}}
	<br>
  <?php print_r($power->powers[0]);?>
    <ul>
      <ul>
      {% for pow in power.powers %}
        <li>name: {{ pow['name'] }}
            <a href='/Faeva/admin/power/delete/{{pow["pid"]}}'> delete</a> |
            <a href='/Faeva/admin/power/edit/{{pow["pid"]}}'> edit</a><br>
            <li>pid : {{pow['pid']}} <br>
            <li>controller : {{ pow['controller']}}<br>
            <li>options : <br>
            <ul>
            {% for opt in pow['options'] %}


                <li>name : {{opt['name']}}
                <a href='/Faeva/admin/power/deleteOption/{{pow["pid"]}}/{{opt["oid"]}}'> delete</a> |
                <a href='/Faeva/admin/power/editOption/{{pow["pid"]}}/{{opt["oid"]}}'> edit</a> |
                <a href='/Faeva/admin/power/addOption/{{pow['pid']}}'> add</a><br>
                <li>action :{{opt["action"]}} <br>
                <br>
            {% endfor%}
          </ul>
      {% endfor %}

      </ul>
    </ul>



    </tbody>
	</table>
</body>
</html>


<script>
	$(function() {
		$('#addnew').click(function() {
			window.location.href = "/Faeva/admin/power/add";
		});

	});

	function del(id) {

		if (confirm("确定要删除吗？")) {

			var url = "index.html";
			window.location.href = url;

		}

	}
/*

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

*/

</script>
