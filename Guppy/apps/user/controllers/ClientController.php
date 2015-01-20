<?php
namespace User\Controllers;

use User\Models\User as User,
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
class AppUser0Controller extends BaseController{
  public function testAction(){
    $data = $this->di->get('mongoDate');
    echo "sfd";
  }

  public function loginAction($loginname, $password){
    if(!$this->request->isPost()){
      // $loginname = $this->request->getPost("loginname");
      // $password = $this->request->getPost("password");
      $query = array();
      $query['loginname'] = $loginname;
      $query['password'] = $password;
      $user = AppUser::getUser($query);

      if($user){
        $identity = array();
        $identity['user-id'] = $user->UserId;
        $this->session->set('identity', $identity);

        $this->echoInfo(200, "success");
        return;
      }else{
        $this->echoInfo(600, "error");
        return;
      }
    }else{
      $this->echoInfo(601, "request must be post method");
    }
  }

  public function qqLoginAction(){
    echo "yes, qqLogin...";
    $openId = $this->request->getPost("openId");
    $accessToken = $this->request->getPost("accessToken");
    if($openId){
      $log =  new LogFile("../log/test.log");
      $log->log("openId : $openId");
      $log->log("accessToken : $accessToken");
    }else{

      $log->log("sorry : sorry");
    }
  }

  public function registerAction($loginname, $password, $repassword, $email){
    if(!$this->request->isPost()){
      // $loginname = $this->request->getPost("loginname");
      // $password = $this->request->getPost("password");
      // $repassword = $this->request->getPost("repassword");
      // $email = $this->request->getPost("email");

      $query = array();
      $query['loginname'] = $loginname;
      $query['password'] = $password;
      $query['repassword'] = $repassword;
      $query['email'] = $email;
      $query = $this->clearRegisterInfo($query);

      if(is_array($query)){
        $result = AppUser::register($query);
      }else{
        return ;
      }


      if(!$result){ //register success
        $this->echoInfo(200, "success");
      }else{
        if(is_array($result)){
          $this->echoInfo($result['code'], $result['msg']);
        }else{
          $this->echoInfo($result, '');
        }
      }
    }else{
      $this->echoInfo(601, 'request must be post method');
    }
  }

  /**
  * 修改密码
  */
  public function updatePwdAction($oldPassword, $newPassword){
    if(!$this->request->isPost()){
      // $oldPassword = $this->request->getPost("oldPassword");
      // $newPassword = $this->request->getPost("newPassword");
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

      // $result = AppUser::updatePassword($oldPassword, $newPassword);
    }
  }

  /**
  * 忘记密码后通过Email更改
  *   必要参数
  */
  public function resetPwdByEmail_steps1Action($email){
    if(!$this->request->isPost()){
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

  public function resetPwdByEmail_steps2Action($UserId, $vCode, $vCode2, $pwd, $repwd){
    if($this->request->isPost()){
      if($pwd === $repwd){
        $session_vCode = $this->session->get('VerificationCode');
        if(!isset($session_vCode) && $session_vCode === $vCode){  //这里的!是用来测试，实际部署时将其删除
          $result = AppUser::updatePwdByEmail2($UserId, $vCode2, $pwd);
          $this->echoInfo($result, '');
        }
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
