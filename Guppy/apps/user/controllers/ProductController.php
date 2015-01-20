<?php
namespace User\Controllers;

use User\Models\AppUser,
    User\Models\Product,
    User\Models\Account,
    User\Auth\Exception,
    Phalcon\Logger\Adapter\File as LogFile,
    User\Controllers\BaseController;

/**
*  User Manage Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class ProductController extends BaseController  {
    public function deleteAction($pid){
      $product = Product::findFirst(array(array('id' => $pid)));
      if($product){
        if($product->delete()){
          $this->echoInfo(0);
          return ;
        }
        throw new \Phalcon\Exception();
      }else{
        $this->echoInfo(609);
      }
    }

    public function addAction($product_infos){
      $json_infos = json_decode($product_infos);
      if($json_infos){
        $product = new Product();
        $product->name = $json_infos['name'];
        $product->cSize = $json_infos['cSize'];
        $product->online = false;
        $product->status = 0;

        if($command->save()){
          $this->echoInfo(0);
          return ;
        }

        throw new \Phalcon\Exception();
      }
    }

    public function addCmdAction($pid, $cmd, $desc, $cmd_name){
      $product = Product::findFirst(array(array('id' => $pid)));
      if($product){
        $command = new Command();
        $command->cmd = $cmd;
        $command->desc = $desc;
        $command->cmd_name = $cmd_name;

        $command->save();
      }else{
        throw new \Phalcon\Exception();
      }
    }

    public function editAction($update_infos){
    }

    /**
    * 查询用户，默认限制为50条用户的数据
    */
    public function listAction($pageNum){
    }

    public function findAction($pid){
    }

    public function searchAction($field, $keyword){
    }
}
