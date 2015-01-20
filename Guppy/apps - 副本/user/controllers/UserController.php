<?php
namespace User\Controllers;

use User\Models\User as User,
    User\Models\Account as Account,
    User\Auth\Exception,
    User\Controllers\BaseController;



/**
*  User Manage Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class UserController extends BaseController{
    public function testsdAction(){
      $methods = $this->getActions();
      print_r($methods);
    }

    public function homeAction(){
      $identity = $this->session->get("identity");


      if(isset($identity)){
        $user = User::getUserById($identity['uid']);
        $this->view->user = $user;
      }else{  //用户身份信息没有，跳转到登录页面


      }
    }


     /**
     *  用户登录的页面
     */
     public function indexAction(){
       if($this->request->isPost()){
          $post = $this->request->getPost();
          $this->view->disable();
          echo "<br>post : ".print_r($post)."<br>";
       }else{
         $identity = $this->session->get("identity");
         if(isset($identity)){
           $name = User::getUserNameById($identity['uid']);
         }else{  //用户身份信息没有，跳转到登录页面

         }
         echo "yes , you are is get";
       }
     }


     public function activeAction($vCode){
       $query = [];
       $query['vCode'] = $vCode;
       $user = User::findFirst(array($query));
       if(!$user){
          echo "<h1>this vCode($vCode) is illegal...</h1>";
          return ;
       }else{
         if($user->vstatus){
           echo "<h1>you are actived, don't again to try actived...</h1>";
         }else{
           $user->vstatus = true;
           echo "active ok ...";
         }
       }
     }

    public function findAction(){
      echo "user controller find action ...";
    }

    public function loginAction(){
      $loginId = $this->request->getPost("uname");
      $pw = $this->request->getPost("pw");

      $query = [] ;
      $query["loginId"] = $loginId;

      $user = User::findFirst(array($query));
      if($user){
        if(count($user) >  0){}
          $auth = $this->di->get("auth");
          echo "<br> type : ".gettype($user);
          $auth->checkUserFlag($user);
          if($user->psw ===  $pw){
            $identity = [];
            $identity['uid'] = $user->uid;
            $identity["email"] = $user->email;
            if(isset($user->acId)){
              $identity['acId'] = $user->acId;
            }else{
              $identity['acId'] = null;
            }
            $this->session->set("identity", $identity);

          }else{
            echo '<script>alert("密码错误!");window.history.go(-1);</script>';
          }
      }else{
        echo '<script>alert("用户名错误!");window.history.go(-1);</script>';
      }
    }

    public function registerAction(){
       if($this->request->isPost()){
         $user = new UserTemp();
         $post =$this->request->getPost();
         $user->name = $post["uname"];
         $user->email = $post["email"];
         $user->pw = $post["pw"];
         $user->repw = $post["pw2"];
         $user->vcode = $post["validateCode"];

        $isOK = $this->validateUserInfoRegister($user);

        if($isOK){
          $u = new User();
          $u->name = $user->name;
          $u->email = $user->email;
          $u->pw = $user->pw;
          $u->vstatus = true;
          $u->age = null;
          $u->age = null;
          $u->apps = [];
          $u->apps[0] = [];
          $u->apps[0]["appId"] = "A123";
          $u->apps[0]["vstatus"] = false;
          $u->apps[0]["roles"] = [];
          $u->apps[0]["roles"][0] = "admin";
          $u->apps[0]["roles"][1] = "general";
          $u->apps[0]["roles"][2] = "editor";

          $result = $u->save();

          $email = $this->di->get("email");
          $email->sendToUser($u);
          header("location: /Faeva/user/user/registerOk");
        }
       }
     }

     public function registerOkAction(){
       echo "请尽快到邮箱激活账号...";
     }
     private function validateUserInfoRegister($user){

      echo "user : ".print_r($user);
       $error = false; //检查用户信息错误的标志

  		//密码检查
  		$len = strlen($user->repw);
  		if(!$user->repw){
  			$error = true;
  			echo '<script>alert("密码不能为空!");window.history.go(-1);</script>';
  		}elseif ($len<5 || $len>50) {
  			$error = true;
  			echo '<script>alert("密码长度必须为5 ~ 50！");window.history.go(-1);</script>';
  		}elseif($user->pw != $user->repw){
  			$error = true;
  			echo '<script>alert("两个密码不一致！");window.history.go(-1);</script>';
  		}elseif (!StrUtil::CheckEmptyString($user->name)){
  			$error = true;
  			echo '<script>alert("用户名不能为空！");window.history.go(-1);</script>';
  		}

  		//验证码校验
  		$len2 = strlen($user->vcode);
  		if(!StrUtil::CheckEmptyString($user->repw)){
  			$error = true;
  			echo '<script>alert("验证码不能为空！");window.history.go(-1);</script>';
  		}elseif ($len2 != 4) {
  			$error = true;
  			echo '<script>alert("验证码的长度必须为4！");window.history.go(-1);</script>';
  		}elseif ($user->vcode !== $_SESSION["validateCode"]){
  			$error = true;
  			echo '<script>alert("验证码的不正确！");window.history.go(-1);</script>';
  		}

      $isOk = User::isExistName($user->name);
      if($isOk){
        $error = true;
        echo '<script>alert("此用户名--已被注册了！");window.history.go(-1);</script>';
      }

      $isOk = User::isExistEmail($user->email);
      if($isOk){
        $error = true;
        echo '<script>alert("此Email已被注册了！");window.history.go(-1);</script>';
      }

      if($error){
        exit();
      }

      return true;
     }

     /**
     *  更改自己个人的资料
     */
     public function updateAction(){
        echo "user controller update action...";
     }

     public function deleteAction(){
       echo "user controller delete action...";
     }
}

class StrUtil{
  /**
   * 检验字符串
   * Enter description here ...
   * @param $C_char
   */
  public static function CheckEmptyString($C_char){
		if (!is_string($C_char)) return false; //判断是否是字符串类型
		if (empty($C_char)) return false; //判断是否已定义字符串
		if ($C_char=='') return false; //判断字符串是否为空
		return true;
	}
}

class UserTemp {
  private $name;
  private $email;
  private $pw;
  private $repw;
  private $vcode;

  /**
		 * 通用的属性set函数；
		 * 	直接使用$user->nickname = "xxx"; good
		 * Enter description here ...
		 * @param unknown_type $property_name
		 * @param unknown_type $value
		 */
		public function __set($property_name, $value){
			$this->$property_name = $value;
		}

		/**
		 * 直接一个通用的get属性的函数，good
		 * 	$user->name; 这样就可以获取对象的属性，good，good,越来越喜欢PHP了
		 * 		在直接获取私有属性值的时候，自动调用了这个__get()方法<br>
		 * Enter description here ...
		 * @param unknown_type $property_name
		 */
		public function __get($property_name){
			if(isset($this->$property_name))
			{
				return($this->$property_name);
			}
			else
			{
				return(NULL);
			}
		}

}
