<?php
namespace App\Controllers;

  use Phalcon\Mvc\Controller;
  require_once "../global/GlobalUtil.php";

/**
*   Role Controller
*       1、本控制类提供角色的增删改查动作
*
*   注意要点：
*       为类防止外部攻击， 在进行此控制器操作之前必须要进行用户的身份角色校验
*
*/
  class RoleController extends Controller{
    public function addAction(){
      if($this->request->isPost()){
        $post = $this->request->getPost();
        echo "<br>post : ".print_r($post)."<br>";

        $roleName = $post["rolename"];
        $status = $post["status"];
        $appId = $this->session->get("appId");

        $user = $this->session->get("user");
        if($user == null){
          echo "你还没有登录！";
        }else{
          $query = [];
          $query["name"] = $roleName;
          $cursor = Role::find(array($query));

          echo "cursor size : ".count($cursor);

          if(count($cursor) > 0){
            echo '<script>alert("sorry, 此角色名已被注册!");window.history.go(-1);</script>';
          }else{
            $role = new Role();
            $role->name = $roleName;
            $role->status = (bool)$status;
            $role->appId = $appId;
            $keys = $this->request->getPost("group");

            if(count($keys) > 0){
               $role->powers = [];
               foreach($keys as $key){
                  $role->powers[count($role->powers)] = [];
                  $role->powers[count($role->powers)-1]["pid"] = $key;
                  $role->powers[count($role->powers)-1]["oids"] = [];
                  $flag = 0;
                  foreach($post[$key."_node"] as $k){
                    $role->powers[count($role->powers)-1]["oids"][$flag++] = $k;
                  }
               }
              $result = $role->save();
              echo "role save result : ".$result ."<br>";
            }else{
              //echo '<script>alert("sorry, 系统不允许创建空白的角色!");window.history.go(-1);</script>';
              echo "post : ".print_r($this->request->getPost());
              echo "<br>no !";
            }
          }
        }
      }else{
        $powersName = $this->session->get("powersName");
        if($powersName != null){

        }else{
          $appId = $this->session->get("appId");
          $powersNameTemp = Power::find(array(
                "appId" => $appId
          ));

          $jsonStr = json_encode($powersNameTemp);
          $powersName = json_decode($jsonStr, true);
          $this->session->set("powersName", $powersName);
        }
        header("location: /faeva.com/bui/Role/add.php");
      }
    }

    public function findByQueryNameAction(){
        $name = $this->request->get("rolename");
        $query = [];
        $query["name"] = new MongoRegex("/$name/");
        $cursor = Role::find(array($query));

        $jsonStr = json_encode($cursor);
        $jsonObj = json_decode($jsonStr, true);
        $result = json_encode($jsonObj);

    	  header("location: /faeva.com/bui/Role/index.php?roles=$result");
        echo "jsonObj : ".print_r($jsonObj);
        echo "<br>";
    }

    public function testAction($controllerName){
        echo "<br>controllerName : $controllerName<br>";

        $query = [];
        $query["name"] = "hang1";
        $query['power.controller'] = $controllerName;

        $role = Role::findFirst(array($query));
        echo "result : ".GlobbalUtil::JsonStr($role);
    }

    /**
    *  获取用户提供用户角色名称
    */
    private function getMyKeys($post){
      $result = [];
      foreach(array_keys($post) as $key){
        $pos = strpos($key, "_node");
        if($pos > 0){
          $result[count($result)] = substr($key, 0, $pos);
        }
      }
      return $result;
    }

    /**
    *   默认是根据角色名来删除角色数据
    */
    public function deleteAction(){
        $name = $this->request->get("name");
        $query = [];
        if($name == null || trim($name) === ""){
          echo '<script>alert("sorry, 角色名不能为空!");window.history.go(-1);</script>';
          return ;
        }
        $query["name"] = $name;
        $cursor = Role::find(array($query));

        if(count($cursor) > 0){
          $role = $cursor[0];
          $result = $role->delete();
        }
        echo "role delete result : ".$result;
    }


    /**
    *   根据角色的Id进行删除（暂时不去实现，由上面的根据name字段删除用着）
    */
    public function deleteByIdAction($id){
      $query = [];
      $query["_id"] = new MongoId($id);

      $role = Role::findFirst(array($query));
      $role->delete();
    }

    /**
    * 更新某个角色的权限
    */
    public function updateAction(){
        $group = $this->request->get("group");
        $roleId = $this->request->get("roleId");
        $status = $this->request->get("status");

        $user = $this->session->get("user");
        $user = $user;
        $appId = $this->session->get("appId");
        $userId = $user['_id']['$id'];

        $insertOptions = []; //设置一个要更新的option数组，下面将数据插入
        $iLen = 0; //记录insertOptions数组的长度
        foreach($group as $pid){
          $optionIds = $this->request->get($pid."_node");

          if(count($optionIds) > 0){
            $insertOptions[$iLen]["pid"] = $pid;
            $len = 0;

            $insertOptions[$iLen]['oids'] = [];
            foreach($optionIds as $oid){
              $insertOptions[$iLen]['oids'][$len++] = $oid;
              // echo "<br> oid : $oid";
            }
          }else{
            //  echo "";
          }
          $iLen++;
        }

        $query = [];
        $query["_id"] = new MongoId($roleId);
        $role = Role::findFirst(array($query));  //获取到要更新的角色对象
        $jsonStr = json_encode($role);
        $jsonObj = json_decode($jsonStr, true);

        $role->powers = $insertOptions;
        $role->status = (bool)$status;
        $role->save();
        // echo　"status : ".gettype($status);

        echo "<br>update successfully";
    }

    /**
    * 查找所有的角色
    */
    public function findAction(){
      	$appId = $this->session->get('appId');
        $cursor = Role::find();

        $jsonStr = json_encode($cursor);
        $jsonObj = json_decode($jsonStr, true);
        $result = json_encode($jsonObj);

        $powersNameTemp = Power::find(array(
              "appId" => $appId
        ));
        $jsonStr = json_encode($powersNameTemp);
        $powersName = json_decode($jsonStr, true);
        $this->session->set("powersName", $powersName);

        header("location: /faeva.com/bui/Role/index.php?roles=$result");
        echo $result;
    }

    /**
    *  根据Id查询role信息
    */
    public function findByIdAction($id){
        $mongoId = new MongoId($id);
        $appId = $this->session->get("appId");
        $query = [];
        $query['_id']  = $mongoId;
        $role = Role::findFirst(array($query));

        $jsonStr = json_encode($role);
        $jsonObj = json_decode($jsonStr, true);
        $this->session->set("role", $jsonObj);
        header("location: /faeva.com/bui/Role/edit.php");
        echo GlobalUtil::toJsonStr($role);
    }

    public function editAction($id){
      $mongoId = new MongoId($id);
      $appId = $this->session->get("appId");

      if($appId == null){
        $appId = "A123";
        echo "appId is null, you are not login this system, please login...";
        //echo "<br>";
      }
      $query = [];
      $query['_id']  = $mongoId;
      $role = Role::findFirst(array($query));
      $jsonStr = json_encode($role);
      $role = json_decode($jsonStr, true);
      $this->session->set("role", $role);

      $powersNameTemp = Power::find(array(
            "appId" => "A123"
      ));
      $jsonStr = json_encode($powersNameTemp);
      $powersName = json_decode($jsonStr, true);
      $this->session->set("powersName", $powersName);

      header("location: /faeva.com/bui/Role/edit.php");
    }
    /**
    *  根据name字段查询Role的字段
    */
    public function findByNameAction($name){
      $query = [];
      $query["name"] = $name;

      $role = Role::findFirst(array($query));
      echo GlobbalUtil::toJsonStr($jsonObj);
    }
}
