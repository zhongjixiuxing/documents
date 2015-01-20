<?php
namespace Account\Controllers;

use Account\Models\Account as Account,
    Account\Auth\Exception,
    Account\Models\App,
    Account\Models\User;

class AccountController extends \Phalcon\Mvc\Controller{

    public function testAction(){
       $user_agent = $this->request->getUserAgent();  //用户代理， 其实就是浏览器的信息
       echo "agent : "; print_r($user_agent);
      //  $this->view->disable();
    }

    public function test2Action(){
      // $this->response->setHeader("Content-Type", "image/jpeg");
      $imagick = $this->di->get("imagick");
      $data = $imagick->getImageBlob();
      $imagick->getImageGeometry();
      // echo $data;
      // header("Content-Type: image/{$Imagick->getImageFormat()}");
      // $Imagick = new Imagick('../public/img/an2.jpg');
      // $data = $Imagick->getImageBlob ();
      // echo $data;
      // file_put_contents ('test.png', $data);
    }

    /**
    *  跳转到指定的account 空间
    */
    public function gotoAction($acId){
      $account = Account::getAccountById($acId);
      if($account){
        $identity = $this->session->get("identity");
        $identity['acId'] = $acId;
        $this->session->set("identity", $identity);
        $this->response->redirect('Faeva2/account/account/home');
        return;
      }else{
        throw new Exception("发现入侵者...非法账号入侵！");
      }
    }

    public function indexAction(){
        $identity = $this->session->get("identity");
        if(!isset($identity)){
          // $this->response->redirect( 'http://localhost/Faeva2/user/user/login', true);
          echo "yes : ..";
          $this->response->redirect("Faeva2/user/user/index");
        }else{
          echo "user is logined...";
        }
    }

    public function homeAction(){
      $identity = $this->session->get("identity");
      if(!isset($identity)){
          $this->view->disable();
          $this->response->redirect("Faeva2/user/user/index");
      }else{
          $user = User::getUserById($identity['uid']);
          $account = Account::getAccountById($identity['acId']);
          if($account){
            $apps = App::getAppsByAcId($identity["acId"]);
            $this->view->apps = $apps;
          }else{
            throw new Exception("非法Account账号...");
          }

          $this->view->user = $user;
          $this->view->account = $account;
          echo "<br> account : ";
          print_r($identity["acId"]);
          // $this->view->disable();
      }
    }

    /**
    * create Account
    *   User only create create Accout once
    */
    public function createAccountAction(){
      $identity = $this->session->get("identity");
      if(isset($identity)){
        if($identity["acId"]){ //已经创建了s
          throw new Exception("用户已经创建了account...");
        }else{
          $account = new Account();
          $user = User::getUserById($identity["uid"]);
          $account->name = $user->name;
          $account->acId = (string)rand();  //强制转换成字符；
          $account->createDate = date('y-m-d h:i:s',time());
          $account->isActive = true;
          $account->save();
          $user->acId = $account->acId;
          $user->save();

          $identity['acId'] = $user->acId;
          $this->session->set("identity", $identity);  //更新session中的数据
          echo "<br> 创建成功...";
        }
      }else{
        throw new Exception("用户还没有登录....");
      }
    }

    /**
    *  选择其他的account空间
    */
    public function selectAcAction($acId){
      $identity = $this->getIdentity();

      if($acId === $identity['acId']){
        throw new Exception("当前已经存在这个account空间中了， 请不要二次选择...");
      }

      $user = User::getUserById($identity["uid"]);
      $account = Account::getAccountById($acId);

      if($account){
        if(!$user){
          throw new Exception("非法用户 ...");
        }
        if(isset($account->uids)){
            foreach($account->uids as $uid){
              if($uid === $user->email){
                $this->gotoAc($acId);
              }
            }
        }else{
          throw new Exception("您不是$acId account 的用户 ...");
        }
      }else{
        throw new Exception("非法入侵...您不是<$acId> accouont 的用户...");
      }
    }

    /**
    * 通过email来邀请其他用户到account users 中
    */
    public function inviteAction($email){
      $identity = $this->session->get("identity");

      if(isset($identity)){
          if(isset($identity['acId'])){
            $account = Account::getAccountById($identity["acId"]);
            if($account){
              if(!isset($account->uids)){
                $account->uids = array();
              }
              foreach($account->uids as $uid){
                if($uid === $email){
                  throw new Exception("当前已经邀请这个用户了，请你重新填写...");
                }
              }

              $account->uids[count($account->uids)] = $email;
              $account->save();
            }else{
              echo "<br> identity : ".$identity["acId"];
              throw new Exception("Account 不存在...");
            }
          }else{
            throw new Exception("用户还灭有没有Account...");
          }
      }else{
        throw new Exception("用户还灭有登录...");
      }
    }

    /**
    *  切换当前用户的account空间
    */
    private function gotoAc($acId){
      $identity = $this->getIdentity();
      echo "<br> 准备从". $identity["acId"] . " 切换到$acId account 空间";
      $identity['acId'] = $acId;
      $this->session->set("identity", $identity);
    }

    private function getIdentity(){
      $identity = $this->session->get("identity");
      if(isset($identity)){
        return $identity;
      }else{
        throw new Exception("用户还灭有登录...");
      }
    }
}
?>
