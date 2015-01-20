<?php
namespace App\Controllers;

  use Phalcon\Mvc\Controller,
      App\Models\App,
      App\Models\User,
      Phalcon\Exception;
/**
*   app Controller
*       1、本控制类提供角色的增删改查动作
*
*/
class AppController extends Controller{
    public function createAppAction(){
      $identity = $this->session->get("identity");
      if(isset($identity)){
          if($this->request->isPost()){
            $name = $this->request->getPost("name");
            $desc = $this->request->getPost("desc");

            $app = new App();
            $user = User::getUserById($identity["uid"]);
            $app->name = $name;
            $app->desc = $desc;
            $app->appId = (string)rand();  //
            $app->acId = $identity['acId']; //强制转换成字符;
            $app->createDate = date('y-m-d h:i:s',time());
            $app->isActive = true;

            echo "<br> name : $name";
            echo "<br> desc : $desc";
            $app->save();
            $this->view->disable();
          }else{}
      }else{
        throw new Exception("用户还没有登录...");
      }
    }

    public function deleteAction($appId){
      $app = App::getAppById($appId);
      if($app){
        if($app->delete()){
          $this->response->redirect("Faeva2/account/account/home");
        }else{
            throw new Exception("删除失败...appId : $appId");
        }
      }else{
        throw new Exception("删除失败, app不存在...appId : $appId");
      }
    }
}
