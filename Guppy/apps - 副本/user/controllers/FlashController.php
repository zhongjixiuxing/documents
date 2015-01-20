<?php
namespace User\Controllers;

use Phalcon\Mvc\Controller,
      Phalcon\Exception;
/**
*
*  Flash 闪存，
*   数据临时保存在服务端内存中，在通过某种机制，自动绑定
*   到html页面上显示，例如在官网的demo上，就是通过html标签的clas
*   属性绑定显示，这个有点之一就是操作方便，没有其他的意义
*
*/
class FlashController extends Controller{

    /***
    *  这个函数已经实现了https的请求，
    *   有点奇怪的是， php服务器自动帮你开启了，
    *    后面的原理我就不想去追究了，能用就好，
    *
    */
    public function showAction(){
      $this->flash->error("too bad! the form had errors");
      $this->flash->success("yes!, everything went very smoothly");
      $this->flash->notice("this a very important information");
      $this->flash->warning("best check yo self, you're not looking too good.");
      $this->flash->outputMessage('error', $message);

    }

}
