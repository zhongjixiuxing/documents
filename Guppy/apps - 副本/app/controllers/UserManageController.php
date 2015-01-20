<?php
namespace App\Controllers;

use Phalcon\Mvc\Controller,
    Admin\Models\User as User;

require_once "../global/GlobalUtil.php";

/**
*  User Manage Controller
*     1、本控制提供用户的增删查改动作
*
*   注意操作点：
*     防止故意攻击系统数据，要求在进行对应操作之前检验用户的身份角色；
*/
  class UserManageController extends Controller{
    public function findByQueryNameAction(){
        $name = $this->request->get("name");
        $query = [];
        // $query['name'] = new MongoRegex("/$name/");
        // $query["name"] = $name;
        $query['name'] = array('$regex' => $name);
        $users = User::find(array($query));
        // $user = User::findFirst(array($query));

        echo "<br>user : ".print_r($user);
        echo "<br>name : ".$name;
        $this->view->pick("");
        // header("location: /Faeva/admin/usermanage/index?name=$name");
    }

    public function addAction(){
        if($this->request->isPost()){
          $post = $this->request->getPost();
          $appId = $this->session->get("appId");

          $name = $post['name'];
          $pw = $post['pw'];
          $email = $post['email'];
          $status = $post['status'];
          $roles = $post['roles'];

          $user = new User();
          $user->name = $name;
          $user->pw = $pw;
          $user->email = $email;
          $user->vstatus = (bool)$status;

          $apps = [];
          $apps[0] = [];
          $apps[0]['appId'] = $appId;
          $apps[0]['vstatus'] = (bool)$status;
          $apps[0]['roles'] = [];

          $strs = explode(";", $roles);
          for($x=0; $x<count($strs); $x++){
            $apps[0]['roles'][$x] = $strs[$x];
          }

          $user->apps = $apps;
          $user->save();
          header("location: /Faeva/admin/usermanage/index");
        }
    }

    public function deleteAction($id){
        // $query['_id'] = new MongoId($id);  //phalcon 框架没有直接包含MongoId
        $user = User::findById($id);

        if($user){
          $user->delete();
          echo "delete successfully";
          header("location: /Faeva/admin/userManage/index");
        }else{
          echo "<br>不存在此用户";
          echo "<br>id : $id";
        }
    }

    public function editAction($id){
      if($this->request->isPost()){

      }else{
        $user = User::findById($id);
        $this->view->user = $user;
      }
    }

    public function indexAction(){
      $name = $this->request->get("name");
      if(isset($name)){
        $query = [];
        $query['name'] = array('$regex' => $name);
        $users = User::find(array($query));
      }else{
        $users = User::find(array(
          "limit" => 50
        ));
      }
      $this->view->users = $users;
    }

    public function updateAction(){

      $post = $this->request->getPost();

      $id = $post['id'];
      $name = $post["name"];
      $pw = $post['pw'];
      $email = $post['email'];
      $vstatus = $post['status'];
      $roles = $post['roles'];

      $strs = explode(";", $roles);
      $updateRoles = [];
      for($x=0; $x<count($strs); $x++){
        $updateRoles[$x] = $strs[$x];
      }

      $user = User::findById($id);

      $user->name = $name;
      $user->pw = $pw;
      $user->email = $email;
      $user->vstatus = $vstatus;
      $user->apps[0]['roles'] = $updateRoles;

      $user->save();

      echo "post : ".print_r($post);
      echo "<br>update successfully....";

    }

    public function findByIdAction(){

    }

    public function findByNameAction(){

    }
  }

?>
