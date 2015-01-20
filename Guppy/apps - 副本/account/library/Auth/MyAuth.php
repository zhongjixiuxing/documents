<?php
namespace User\Auth;

use Phalcon\Mvc\User\Component;
use User\Models\User;

/**
 * Vokuro\Auth\Auth
 * Manages Authentication/Identity Management in Vokuro
 */
class MyAuth extends Component{
  /**
  * 检查当前用户的状态
  *
  * @return boolean
  */
  public function checkUserFlag($user){
    if($user === null){
      throw new Exception("用户为空");
    }else if(!$user->isActive){
      throw new Exception("用户还没有激活");
    }
  }

}
