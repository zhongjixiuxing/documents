<?php
namespace Client\Controllers;

use Client\Models\User as User,
    Client\Models\AppUser as AppUser,
    Client\Models\Account as Account,
    Client\Auth\Exception,
    Phalcon\Logger\Adapter\File as LogFile,
    Client\Controllers\BaseController;

/**
*  User Manage Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class ClientController extends BaseController{

  public function loginAction(){
    if($this->request->isPost()){
      $loginname = $this->request->getPost("loginname");
      $password = $this->request->getPost("password");
      $query = array();
      $query['loginname'] = $loginname;
      $query['password'] = $password;
      $user = AppUser::getUser($query);
      if($user){
        $identity = array();
        $identity['user-id'] = $user->UserId;
        $this->session->set('identity', $identity);
        $this->echoInfo(0, "success");
        return;
      }else{
        $this->echoInfo(609, "error");
        return;
      }
    }else{
      $this->echoInfo(601, "request must be post method");
    }
  }



  /**
  * 修改密码
  */
  public function updatePwdAction(){
    if(!$this->request->isPost()){
      $oldPassword = $this->request->getPost("oldPassword");
      $newPassword = $this->request->getPost("newPassword");
      $identity = $this->session->get('identity');
      echo "password : ".$identity['user-id'];
      if(isset($identity)){
        $result = AppUser::updatePwd($identity['user-id'], $oldPassword, $newPassword);
        if(!$result){
          $this->echoInfo(200, "success");
        }else{
          $this->echoInfo($result['code'], $result['msg']);
        }
      }
    }
  }

  /**
  * 忘记密码后通过Email更改
  *   必要参数
  */
  public function resetPwdByEmail_steps1Action(){
    if(!$this->request->isPost()){
      $email = $this->request->get('email');
      $vCode = $this->request->get('VerificationCode');
      $session_vCode = $this->session->get('VerificationCode');

      if(!isset($session_vCode) && $session_vCode === $vCode){  //这里的!是用来测试，实际部署时将其删除
        if($this->valiEmail($email)){
          $emailUtil = $this->di->get("email");
          $result = AppUser::updatePwdByEmail($email, $emailUtil);
          if($result){

          }
        }
      }else{
          $this->echoInfo(612, "error");
      }
    }else{
    }
  }

  public function resetPwdByEmail_steps2Action(){
    if($this->request->isPost()){
      $post = $this->request->getPost();
      $UserId = $post['UserId'];
      $vCode = $post['vCode'];
      $pwd = $post['password'];
      $repwd = $post['repassword'];

      if($pwd === $repwd){
        $result = AppUser::updatePwdByEmail2($UserId, $vCode, $pwd);
        $this->echoInfo($result, '');
      }else{

      }
    }
  }

  /**
  * 整理用户注册时的信息
  */
  private function clearRegisterInfo($query){
    $result = array();
    if(isset($query['loginname']) && isset($query['email']) && isset($query['password'])
      && isset($query['repassword'])){ //飞空校验
        if($query['password'] === $query['repassword']){               //密码一致校验
          if(!preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/",$query['email'])){  //email 格式校验
            return 605;
          }

          $result['loginname'] = $query['loginname'];
          $result['password'] = $query['password'];
          $result['email'] = $query['email'];

          return $result;
        }else{
          return 610;
        }
    }else{
      return 609;
    }
  }

  //0错误，1正确
  public function valiEmail($email){
    return preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/",$email);
  }



}
