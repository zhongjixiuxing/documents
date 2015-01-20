<?php
namespace App\Controllers;

  use Phalcon\Mvc\Controller,
      Phalcon\Exception;

/**
*   Role Controller
*       1、本控制类提供角色的增删改查动作
*
*/
  class IndexController extends Controller{

    public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher){

        $controllerName = $dispatcher->getControllerName();
        echo "<br>in controller controllerName : $controllerName";

        if($controllerName === "index"){
          // $file = '../apps/admin/dirlist.php';
          // $f = fopen($file, 'w');
          // $data = "11";
          // $st = print_r($act);
          // fwrite($f,"sdfsdfsd111sdfsd1");
          // fclose($f);

          throw new Exception('Can`t find user by controller = ' . $controllerName, 401);  //直接抛出401 权限异常

          return false;
          // header("location: /Faeva/user");
          echo "<br> you are no limit to access this module...";
        }

        return ;
    }

    public function indexAction(){
      $file = '../apps/admin/dirlist.php';
      $f = fopen($file, 'w');
      $data = "11";
      $st = print_r($act);
      fwrite($f,"anxin.sdfs..");
      fclose($f);

      $this->view->adminName = "anxing";
      echo "<br><h1>yse, this IndexController indexAction module....</h1>";
    }

    public function index2Action(){
      echo "in";
    }
  }
