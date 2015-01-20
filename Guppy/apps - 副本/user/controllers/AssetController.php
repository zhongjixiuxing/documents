<?php
namespace User\Controllers;

use Phalcon\Mvc\Controller,
      User\Models\User,
      Phalcon\Exception;
/**
*
*  使用phalcon中的assets资产管理器，在controller中设置好css和js文件中
*   然后可以再phalcon模板上非常方便地输出，good 东西
*
*/
class AssetController extends Controller{

    /**
    * 在服务器Controller中设置html页面上的css和js文件链接， 这个框架真的是牛
    */
    public function indexAction(){
      $this->assets
          ->collection('headerCss')          //头部的css位置
          ->addCss("Faeva2/css/admin/style.css")
          ->addCss("Faeva2/css/admin/bootstrap.css")
          ->addCss('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css', true);
          // ->addJs("//libs.baidu.com/jquery/1.9.0/jquery.js", true);  //这种方式有bug，具体自己看页面上的源代码

      $this->assets
          ->collection('headerJs')          //头部的Js位置
          ->addJs("//libs.baidu.com/jquery/1.9.0/jquery.js", true);
    }
}
