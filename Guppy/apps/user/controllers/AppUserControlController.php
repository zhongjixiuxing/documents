<?php
namespace User\Controllers;

use User\Models\QQUser,
    User\Models\AppUser,
    User\Models\Account as Account,
    User\Auth\Exception,
    Phalcon\Logger\Adapter\File as LogFile,
    User\Controllers\BaseController;

/**
*  User Manage Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class AppUserControlController extends BaseController  {

    public function deleteAction($UserId){
      if($UserId){
        $user = AppUser::findFirst(array(array('UserId' => $UserId)));
        if($user){
          $result = $user->delete();
          if($result){
            $this->echoInfo(0, '');
            return;
          }
        }else{
          $this->echoInfo(609, 'userid is illegal');
        }
      }
    }

    /**
    *   method: post
    *   必要参数：
    *     loginname：登录名(长度必须大于或等于5)
    *     password:  密码 （长度必须大于或等于5）
    *     email：    email
    *
    */
    public function addAction($user_infos){
      $arr = json_decode($user_infos, true);
      $result = $this->valiUserInfo($arr);
      if(!$result){
        $user = new AppUser();

        $user->loginname = $arr['loginname'];
        $user->password = $arr['password'];
        $user->email = $arr['email'];

        if($user->save()){
          $this->echoInfo(0,'');
        }
      }else{
        $this->echoInfo($result,'');
      }
    }

    /**
    * 修改用户的信息（支持修改多个用户）
    *   如果错误会输出
    * @param string $update_infos
    */
    public function editAction($update_infos){
      //[{"UserId":"61366A5FD2A1BA6A1C78FF8A9AE9EDE2", "gender":"女"}]  "":""
      $users = json_decode($update_infos, true);
      $errors = $this->valiUpdateInfo($users);
      if(count($errors) === 0){
        $this->echoInfo(0, '');
      }else{
        $this->echoInfo(618, $errors, true);
      }
    }


    /**
    *
    * 查询用户，采用分页的方式
    *   每次限制50用户的消息
    * @method : get
    */
    public function listAction(){
      $pageNum = 1;
      if($pageNum){
        $skip = ($pageNum-1) * 50;
      }else{
        $skip = 0;
      }

      $users = AppUser::find(array(
        'limit' => 50,
        'skip'  => $skip
      ));
      echo json_encode($users);
    }

    public function findAction($UserId){
      $user = AppUser::getUser(array('UserId' => $UserId));
      if($user){
      }
      echo json_encode($user);
    }

    /**
    * 给定特定的字段查找用户(此接口是&&查询,也不支持模糊查询)
    * @param string 请求的参数
    * @return 成功返回用户的信息，找不到返回false
    *
    */
    public function searchAction($fields){
      $fields = json_decode($fields, true);
      if($fields){
        $users = AppUser::getUser($fields);
        echo json_encode($users);
      }else{
        $this->echoInfo(609, '');
      }
    }

    private function valiUserInfo($arr){
      if(count($arr) > 0)
        if(isset($arr['loginname']) && isset($arr['password']) && isset($arr['email'])){
          if(strlen($arr['loginname']) <= 5){
            return 615;
          }elseif(strlen($arr['password']) <= 5){
            return 616;
          }elseif(AppUser::isExistField(array('loginname' => $arr['loginname']))){
            return 602;
          }elseif(AppUser::isExistField(array('email' => $arr['email']))){
            return 603;
          }

        }
    }

    private function valiUpdateInfo($users){
      $errors = [];
      if($users){
        foreach($users as $user){
          $u = AppUser::findFirst(array(array('UserId' => $user['UserId'])));
          if($u){
            foreach($user as $key => $value){
              if(AppUser::isPrivateField($key)){  //检出是否是数据表中的私有字段
                if(!isset($errors[$u->UserId])){
                  $errors[$u->UserId] = [];
                }
                $errors[$u->UserId][$key] = $key;
                break;
              }
              $u->$key = $value;
            }
            $u->save();
          }
        }
      }

      return $errors;
    }
}
