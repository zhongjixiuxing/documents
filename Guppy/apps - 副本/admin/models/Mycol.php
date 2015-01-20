<?php
  namespace Admin\Models;

  use \Phalcon\Mvc\Collection;

  /**
  *  Role model
  *
  * --table : role
  */
  class Mycol extends Collection{
    public function getResource(){
      return "mycol";
    }

    /**
    *  collection 对象初始化调用的函数，可以在里面进行初始化数据库链接
    */
    public function initialize(){
      echo "<br> test Model initialize...";
       $this->setConnectionService('mongo2');
    }
  }
