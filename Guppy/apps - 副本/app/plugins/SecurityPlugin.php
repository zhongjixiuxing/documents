<?php
namespace App\Plugins;

use Phalcon\Events\Event,
	Phalcon\Mvc\User\Plugin,
	Phalcon\Mvc\Dispatcher,
	Phalcon\Acl,
	Admin\Models\Role as Role,
	Admin\Models\Power as Power;

	// require_once "../apps/admin/config/config.php";

	class SecurityPlugin extends \Phalcon\Mvc\User\Plugin{
		public static $num  = 0;  //这个数据并不能持久，使用persistent可以实现相同的功能，如下面的例子（实际上测试成功）

		public function getAcl2(){

			echo "<br> getAcl2..<br>";
			if (!isset($this->persistent->acl)){
				echo "acl is null...";
				//创建一个phaicon Acl
				$acl = new \Phalcon\Acl\Adapter\Memory();

				//默认的action是 DENY access (拒绝访问)
				$acl->setDefaultAction(\Phalcon\Acl::DENY);

				//$appId = $this->session->get("appId");
				$appId = "A864";
				if(!isset($appId)){
					header("location: /Faeva/user/user/index");
					return false;
				}

				$this->persistent->appId = $appId;    //设置一个appId到用户的会话区域

				$query = [];
				$query["appId"] = $appId;
				echo "<br>appId : $appId<br>";

				$rolesObjs = Role::find(array($query)); //获取当前应用的所有角色出来(appId);
				$powerObj = Power::findFirst(array($query)); // 获取当前应用的所有权限(appId);



				$roles = [];   //存放phalcon 格式的角色数组
				foreach($rolesObjs as $roleObj){
					$roleName = $roleObj->name;
					echo "<br>roleName : $roleName<br>";
					$roles[$roleName] = new \Phalcon\Acl\Role($roleName);
				}



				foreach ($roles as $role) {
					$acl->addRole($role);
				}

				//设置一个私有的路径（这里指的是后台），并注册到Acl中
				//Private area resources (backend)
				$privateResources = [];
				foreach($powerObj->powers as $power){
					$controller = $power['controller'];
					$actions = [];
					foreach($power['options'] as $option){
						$actions[count($actions)] = $option["action"];
					}
					$privateResources[$controller] = $actions;
				}

				foreach ($privateResources as $resource => $actions) {
					$acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
				}
				$x = 0;
				foreach($rolesObjs as $roleObj){
						$roleName = $roleObj->name;

						foreach($roleObj->powers as $power){
							$pid = $power['pid'];
							$controlName = $this->getControllerName($powerObj, $pid);
							if($controlName == null){
								continue;
							}

							foreach($power["oids"] as $oid){

								$acts = $this->getActionNames($powerObj, $pid, $oid);
								foreach($acts as $act){
									echo "<br>acl roleName : $roleName";
									echo "<br>acl controller : $controlName";
									echo "<br>acl action : $act";
									$acl->allow($roleName, $controlName, $act);
								}
							}
						}
				}


				$this->persistent->acl = $acl;
			}else{
				echo "ok is created...";
			}

			return $this->persistent->acl;
		}

		/**
		*	h获取Acl 访问控制列表
		* 	acl 存储在phalcon persistent 会话区域内；
		* 	role controller action 都是从数据库中动态加载，
		*
		* 	缺陷：不能够即时更新，更新一次需要客户端或者服务端断开连接后重新连接；
		*/
		public function getAcl(){
			if (!isset($this->persistent->acl)) {  //$this->persiste
				//创建一个phaicon Acl
				$acl = new \Phalcon\Acl\Adapter\Memory();

				//默认的action是 DENY access (拒绝访问)
				$acl->setDefaultAction(Phalcon\Acl::DENY);

				$appId = $this->session->get("appId");
				if(!isset($appId)){
					header("location: /Faeva/user/user/index");
					return false;
				}
				$this->persistent->appId = $appId;    //设置一个appId到用户的会话区域

				$query = [];
				$query["appId"] = $appId;
				echo "<br>appId : $appId<br>";

				$rolesObjs = Role::find(array($query)); //获取当前应用的所有角色出来(appId);
				$powerObj = Power::findFirst(array($query)); // 获取当前应用的所有权限(appId);

				$roles = [];   //存放phalcon 格式的角色数组
				foreach($rolesObjs as $roleObj){
					$roleName = $roleObj->name;
					echo "<br>roleName : $roleName<br>";
					$roles[$roleName] = new \Phalcon\Acl\Role($roleName);
				}

				foreach ($roles as $role) {
					$acl->addRole($role);
				}


				//设置一个私有的路径（这里指的是后台），并注册到Acl中
				//Private area resources (backend)
				$privateResources = [];
				foreach($powerObj->powers as $power){
					$controller = $power['controller'];
					$actions = [];
					foreach($power['options'] as $option){
						$actions[count($actions)] = $option["action"];
					}
					$privateResources[$controller] = $actions;
				}

				foreach ($privateResources as $resource => $actions) {
					$acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
				}

				foreach($rolesObjs as $roleObj){
						$roleName = $roleObj->name;
						foreach($roleObj->powers as $power){
							$pid = $power['pid'];
							$controlName = $this->getControllerName($powerObj, $pid);
							if($controlName == null){
								continue;
							}
							foreach($power["oids"] as $oid){
								$actionName = $this->getActionName($powerObj, $pid, $oid);


								$acl->allow($roleName, $controlName, $actionName);
							}
						}
				}

				$this->persistent->acl = $acl;
			}

			return $this->persistent->acl;
		}


		/**
		*	 获取pid 在powerObj中的名称(name)
		*/
		private function getControllerName($powerObj, $pid){
			foreach($powerObj->powers as $power){
				if($power['pid'] === $pid){
					return $power['controller'];
				}
			}
			return null;
		}

		private function getActionNames($powerObj, $pid, $query){
			$result = [];


			foreach($powerObj->powers as $power){
				if($power['pid'] === $pid){
					if(strpos($query,"*") > 0){
						$len = strlen($query) - 1;
						$query = substr($query, 0 , $len);
					}else{
						$len = strlen($query);
					}
					foreach($power['options'] as $option){
						if (substr($option['name'], 0, $len) == $query) {
							$result[count($result)] = $option["name"];
						}
					}
				}
			}

			echo "<br> result : ";print_r($result);

			return $result;
		}

		private function getActionName($powerObj, $pid, $oid){
			 foreach($powerObj->powers as $power){
				if($power['pid'] === $pid){
					foreach($power['options'] as $option){
						if($option['oid'] === $oid){
							return $option['action'];
						}
					}
				}
			}
		}

		private function getUserRoles($user){
				// $appId = $this->session->get("appId");
				$appId = "A864";
					foreach($user['apps'] as $app){
						if($app['appId'] === $appId){
							return $app['roles'];
						}
					}
		}

		/**
		 * 这个函数在请求到phaicon容器时，在进行路由分发之前进行调用（相当于就是一个拦截器）
		 *
		 * @param Event $event 上下文事件对象，啥，再说一遍？不明白！
		 * @param Dispatcher $dispatcher 路由分发器
		 */
		public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher){

			//获取session的user对象数据
			$user = $this->session->get("user");
			$allow = null;

			//获取请求的控制器名称和action名称
			$controller = $dispatcher->getControllerName();
			$action  = $dispatcher->getActionName();
			echo "<br> require controller : $controller <br>";
			echo "<br> require action : $action <br>";

			//echo "<br>user : ".print_r($user);
			if($user != null){   //如果user不为空，说明用户已经登录成功，则设置身份为User，否则说明用户没有登录，设置身份为游客
				//$role = "User";
				$roles = $this->getUserRoles($user);
				echo "<br>  roles : ".print_r($roles);

				//获取Acl 啥东西来的呀
				$acl = $this->getAcl2();

				//通过acl判断role身份的请求在当前请求的controller和action有没有访问的权限
				$allow = null;
				foreach($roles as $role){

						echo "<br>role : ".$role;

						$allow = $acl->isAllowed($role, $controller, $action);
						if($allow == Acl::ALLOW){
							break;
						}
				}
			}else{
				if($controller === "user" && ($action === "login" || $action === "register" || $action === "register2")){
					$allow = Acl::ALLOW;
				}
			}

			if($allow != Acl::ALLOW){ //如果没有访问权限，转发到错误处理页面，并返回false停止路由分发
				echo "you don't has access limit to read $controller/$action";
				return false;
			}


		}
	}
