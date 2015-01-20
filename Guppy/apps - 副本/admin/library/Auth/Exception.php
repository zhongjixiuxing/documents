<?php
namespace Admin\Auth;

class Exception extends \Exception
{
  private $e;
  function __construct(\Phalcon\Exception $e) {
    $this->e = $e;
  }

  //打印错误到控制台
  public function excute(){
    $code = $this->e->getCode();
    echo "<br> exception code : $code";
  }
}
