<?php
namespace User\Controllers;

use User\Models\QQUser,
    User\Models\AppUser as AppUser,
    User\Models\Account as Account,
    User\Auth\Exception,
    Phalcon\Logger\Adapter\File as LogFile,
    User\Controllers\BaseController;

/**
*  User Manage Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class QQUserController extends BaseController{

  public function testAction(){
    // $data = $this->di->get('mongoDate');

    error_reporting(E_ALL^E_NOTICE);  //close notice information
    $user = QQUser::findFirst();
      $info = $user->loginnamesd;
      if($info){
        echo "yes";
      }else{
        echo "no";
      }

  }

  public function loginAction($user_infos){
    error_reporting(E_ALL^E_NOTICE);  //close notice information
    if(!$this->request->isPost()){
      // $user_infos = $this->request->get('user_infos');
      $user_infos = json_decode($user_infos, true);
      $user = QQUser::getUser($user_infos);
      if(is_object($user)){
        $identity = array();
        $identity['user-id'] = $user->UserId;
        $this->session->set('identity', $identity);
        $this->echoInfo(0, "success");
      }else{
        $this->echoInfo(614, "user is not exist");
      }
    }else{
      $this->echoInfo(601, "request must be post method");
    }
  }

}
