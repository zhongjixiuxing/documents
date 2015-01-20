<?php
namespace User\Controllers;

use Phalcon\Mvc\Controller,
      Phalcon\Exception;
/**
*
*  这个filter 有那么的一点点意义container
*
*/
class FilterController extends Controller{
    /***
    *  这个函数已经实现了https的请求，
    *   有点奇怪的是， php服务器自动帮你开启了，
    *    后面的原理我就不想去追究了，能用就好，
    */
    public function showAction($int){
      $filter = $this->filter;

      $email = $this->request->get("email","email");
      $productId = $this->filter->sanitize($int, "int");

      //这里自动将（）符号去掉
      $result = $filter->sanitize("some(one)@exa\mple.c*)om", "email");

      echo "<br>productId : $productId";
      echo "<br> email : $email";
      echo "<br> result : $result";
    }

}
