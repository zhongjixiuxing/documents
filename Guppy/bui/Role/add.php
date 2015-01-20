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
	<form action="/faeva.com/user/role/add" method="post" class="definewidth m20">
		<table class="table table-bordered table-hover definewidth m10">
			<tr>
				<td width="10%" class="tableleft">角色名称</td>
				<td><input type="text" name="rolename" /></td>
			</tr>
			<tr>
				<td class="tableleft">状态</td>
				<td><input type="radio" name="status" value="1" checked /> 启用 <input
					type="radio" name="status" value="0" /> 禁用</td>
			</tr>
			<tr>
				<td class="tableleft">权限</td>
				<td>
					<ul>

						<?php
								$powersName = $_SESSION["powersName"];

								//所有的权限,并处理好用户当前拥有的权限关系，并显示到界面上
								foreach($powersName as $powers){
										foreach($powers["powers"] as $power){
											echo "<li><label class='checkbox inline'>";
											echo "<input type='checkbox' name='group[]' value='".$power["pid"]."'/>".$power["name"]."</label>";
											echo "<ul>";
											foreach($power["options"] as $option){
													echo "<li><label class='checkbox inline'>";
													echo "<input type='checkbox' name='".$power['pid']."_node[]' value='".$option['oid']."'/>".$option["name"]."</label>";
											}
											echo "</ul></li>";
										}
									}
						?>

						<li><label class='checkbox inline'><input
								type='checkbox' name='user_group[name]' value='"用户"' />用户</label>
						<ul>
								<li><label class='checkbox inline'><input
										type='checkbox' name='user_node[]' value='find' />用户列表</label>
								<li><label class='checkbox inline'><input
										type='checkbox' name='user_node[]' value='add' />用户添加</label>
								<li><label class='checkbox inline'><input
										type='checkbox' name='user_node[]' value='edit' />用户编辑</label>
								<li><label class='checkbox inline'><input
										type='checkbox' name='user_node[]' value='delete' />用户删除</label>
							</ul></li>
					</ul>
				</td>
			</tr>
			<tr>
				<td class="tableleft"></td>
				<td>
					<button type="submit" class="btn btn-primary" type="button">保存</button>
					&nbsp;&nbsp;
					<button type="button" class="btn btn-success" name="backid"
						id="backid">返回列表</button>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
<script>
	$(function() {
		$(':checkbox[name="group[]"]').click(
				function() {
					$(':checkbox', $(this).closest('li')).prop('checked',
							this.checked);
				});
		$('#backid').click(function() {
			window.location.href = "index.html";
		});
	});
</script>
