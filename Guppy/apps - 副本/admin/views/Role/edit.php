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
<script src="http://apps.bdimg.com/libs/angular.js/1.2.15/angular.min.js"></script>


<script type="text/javascript">
	function customersController($scope,$http) {
		$scope.firstName = "huang";
		$scope.lastName =  "hang";
		// $http.get("http://localhost:1034/faeva.com/user/role/edit/54859462663ec51b2f6f24bf")
	  // 		.success(function(response) {
		// 			alert("success..."+response);
		//  		$scope.role = response["role"];
		// 		$scope.powersName = response["powersName"];
		// });
	}

</script>
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
<body ng-app="" ng-controller="customersController">

	<?php
			$appId = $_SESSION["appId"];
			$role = $_SESSION["role"];
			$powersName  = $_SESSION['powersName'];
			echo "keys : ".print_r(array_keys($_SESSION));

			echo "appId : $appId<br>";
			echo "<br>";
			echo "role : <br>".print_r($role);
			echo "<br>";
			echo "powersName : <br>".print_r($powersName);
			echo "<br>";
	?>

<div>
	{{firstName}} | {{lastName}}
</div>
	<form action="/faeva.com/user/role/update" method="post" class="definewidth m20">
		<input type="hidden" name="roleId" value="<?php
		$_id = json_encode($role["_id"]);
		$_id = json_decode($_id, true);
		echo $_id['$id']; ?>" />

		<table class="table table-bordered table-hover definewidth m10">
			<tr>
				<td width="10%" class="tableleft">标题</td>
				<td><input type="text" name="title" value="" /></td>
			</tr>
			<tr>
				<td class="tableleft">状态</td>
				<td><input type="radio" name="status" value="1" checked /> 启用
					<input type="radio" name="status" value="0" /> 禁用</td>
			</tr>
			<tr>
				<td class="tableleft">权限</td>
				<td><ul>

						<?php
						echo "<br> roles ---".print_r($role);
						echo "<br>";
						$oidArr = [];

						//获取当前用户拥有的option id数组
						foreach($role["powers"] as $power){
							for($x=0; $x<count($power['oids']); $x++){ 
								$oidArr[count($oidArr)] = $power['oids'][$x];
							}
						}

						//所有的权限,并处理好用户当前拥有的权限关系，并显示到界面上
						foreach($powersName as $powers){
								foreach($powers["powers"] as $power){

									echo "<li><label class='checkbox inline'>";
									echo "<input type='checkbox' name='group[]' value='".$power["pid"]."' checked/>".$power["name"]."</label>";
									echo "<ul>";
									foreach($power["options"] as $option){
											$check = "";
											foreach($oidArr as $o){
												if($o === $option['oid']){
													$check = "checked";
													break;
												}
											}
											echo "<li><label class='checkbox inline'>";
											echo "<input type='checkbox' name='".$power['pid']."_node[]' value='".$option['oid']."' ".$check." />".$option["name"]."</label>";
									}
									echo "</ul></li>";

									//echo "<br>myPoser : ".print_r($power);
									//echo "<br>";
								}
							}


							function getOptions($powersName, $pid){
								foreach($powersName[0]["powers"] as $power){
									if($power["pid"] === $pid){
										return $power["options"];
									}
								}
								return null;
							}

							/**
							*	 获取option 的名称
							*/
							function getOptionName($options, $oid){
									$result = [];
									foreach($options as $option){
										if($option["oid"] === $oid){
											return $option["name"];
										}
									}
									return null;
							}

							/**
							* 	获取option数组
							*/
							function getOption($options, $oid){
								foreach($options as $option){
									if($option["oid"] === $oid){
										return $option;
									}
								}
								return null;
							}

							/**
							*  获取power 的名称
							*/
							function getPowerParam($powers, $pid, $paramName){
									$len = 0;
									foreach($powers as $power){
										if($power["powers"][$len]["pid"] === $pid){
											return $power["powers"][$len][$paramName];
										}
									}

									return null;
							}
						?>
					</ul></td>
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
