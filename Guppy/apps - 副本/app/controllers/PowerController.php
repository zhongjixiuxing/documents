<?php
namespace App\Controllers;

use Phalcon\Mvc\Controller as Controller,
    Phalcon\Exception as Exception,
      Admin\Models\Power as Power;

require_once "../global/GlobalUtil.php";

/**
*  Power Controller
*     1、本控制类是操作权限管理
*
*   注意操作点：
*     防止故意攻击系统数据，要求在进行对应操作之前检验用户的身份角色；
*/
  class PowerController extends Controller{



    public function myTestAction(){
        $query = [];
        $query['powers.options.oid'] = "456654";
        $cursor = Power::findFirst(array(
          "conditions" => $query,
          'fields' => array('powers' => true)
        ));
        print_r($cursor);
    }

    public function findByQueryNameAction(){
      if(!$this->request->isPost()){
        $name = $this->request->get("name");
        $query = [];
        $query['name'] = $name;

        echo "you are find name : $name<br>";
        echo "i'm so sorry! thank you for your support, this module is no finish, <br>";
        echo "we will inform you after the completion of this module...";
      }
    }

    public function editOptionAction($pid, $oid){
        if(!$this->request->isPost()){

          $query = [];
          $query['powers.options.oid'] = $oid;

          $cursor = Power::findFirst(array(
              $query
          ));

          foreach($cursor->powers as $power){
            if($power['pid'] === $pid){
              foreach($power['options'] as $option){
                if($option['oid'] === $oid){
                  $this->view->oid = $oid;
                  $this->view->pid = $pid;
                  $this->view->name = $option['name'];
                  $this->view->action = $option['action'];
                  break;
                }
              }
              break;
            }
          }
        }else{
          $this->view->pick("");

          $name = $this->request->getPost("name");
          $action = $this->request->getPost("action");

          $query = [];
          $query['powers.options.oid'] = $oid;
          $power = Power::findFirst(array($query));

          $flag = false;
          $size = 0;
          $size1 = 0;
          $index = 0;  //标志pid在powers的位置
          $index1 = 0; //标志oid在power的位置
          foreach($power->powers as $pow){
            if($pow['pid'] !== $pid){
            }else{
              $index = $size;
              foreach($pow['options'] as $opt){
                if($opt['oid'] !== $oid){
                  echo "<br>oid : ".$opt['name'];
                  if($opt['name'] === $name){
                    echo "<br>yse : ".$name;
                    $flag = true;
                    echo "<script>alert('系统已存在<$name>name!');window.history.go(-1);</script>";
                    return ;
                  }elseif($opt['action'] === $action){
                    echo "<br> action : ".$action;
                    $flag = true;
                    echo "<script>alert('系统已存在<$action>action!');window.history.go(-1);</script>";
                    return ;
                  }else{
                    if($opt['name'] === $name){
                      if($opt['action'] === $action){
                        $flag = true;
                        break;
                      }
                    }
                  }
                }else{
                  $index1 = $size1;
                }
                ++$size1;
              }
            }
            $size++;
        }

        if(!$flag){
            echo "<br>-name : ".$power->powers[$index]['options'][$index1]['name'];
            echo "<br>-controller : ".$power->powers[$index]['options'][$index1]["action"];

            $power->powers[$index]['options'][$index1]['name'] = $name;
            $power->powers[$index]['options'][$index1]["action"] = $action;
            $power->save();

            echo "<br> update successfully ...";
        }

        header("location: /Faeva/admin/power/index");
      }
    }

    public function editAction($pid){
      echo "<br>pid : $pid";
        if(!$this->request->isPost()){
            $query = [];
            $query['powers.pid'] = $pid;

            $power = Power::findFirst(array($query));
            // echo "<br>power : ".print_r($power->powers);
            foreach($power->powers as $pow){
              if($pow['pid'] === $pid){
                $this->view->pid = $pid;
                $this->view->name = $pow['name'];
                $this->view->controller = $pow['controller'];
                echo "ysej;  ";
                break;
              }
            }
        }else{
          $query = [];
          $query['powers.pid'] = $pid;
          $power = Power::findFirst(array($query));

          $name = $this->request->getPost("name");
          $controller = $this->request->getPost("controller");

          $flag = false;
          $size = 0;
          $index = 0;
          foreach($power->powers as $pow){
            echo "<br> pow : ".print_r($pow);
            if($pow['pid'] !== $pid){
              if($pow['name'] === $name){
                  $flag = true;
                  echo "<script>alert('系统已存在<$name>name!');window.history.go(-1);</script>";
                  return ;
              }elseif($pow['controller'] === $controller){

                $flag = true;
                echo "<script>alert('系统已存在<$controller>controller!');window.history.go(-1);</script>";
                return ;
              }
            }else{
              $index = $size;
              if($pow['name'] ===$name){
                if($pow['controller'] === $controller){
                   $flag = true;
                  break;
                }
              }
            }
            $size++;
          }

          if(!$flag){
              echo "<br>-name : ".$power->powers[$index]["name"];
              echo "<br>-controller : ".$power->powers[$index]["controller"];

              $power->powers[$index]["name"] = $name;
              $power->powers[$index]["controller"] = $controller;
              $power->save();
          }
          header("location: /Faeva/admin/power/index");
          // echo "<br>over ...";
        }
    }

    public function updateAction(){
      echo "Controller udpate";
    }

    public function deleteOptionAction($pid, $oid){
      $query = [];
      $query["powers.options.oid"] = $oid;
      $power = Power::findFirst(array($query));

// array_splice($arr,$size,1);
//unset($arr[$size]); //这种方式删除数组元素后的游标不会重新排序,解决方法在上面
      $size = 0;
      foreach($power->powers as $pow){
        if($pow['pid'] === $pid){

          $len=0;
          foreach($pow['options'] as $opt){
            if($opt["oid"] === $oid){
              array_splice($power->powers[$size]['options'], $len, 1);
              echo "<br>opt type : ".gettype($opt);
              echo "<br>delete oid : $oid";
            }
            $len++;
          }
          break;
        }
        $size++;
      }
      $power->save();
      echo "delete successfully";
      header("location: /Faeva/admin/power/index");
    }

    public function addOptionAction($pid){
      if($this->request->isPost()){
        $name = $this->request->getPost("name");
        $action = $this->request->getPost("action");

        $query = [];
        $query['powers.pid'] = $pid;

        $option = [];
        $option["oid"] = GlobalUtil::uuid();
        $option["name"] = $name;
        $option["action"] = $action;

        $power = Power::findFirst(array($query));
        $size = 0;
        foreach($power->powers as $pow){
          if($pow['pid'] === $pid){
            echo "<br>pid : $pid";
            $flag = 0;
            foreach($pow['options'] as $opt){
              if($opt['name'] === $name){
                $flag = 1;
                break;
              }else if($opt['action'] === $action){
                $flag = 2;
                break;
              }
            }

            if($flag == 1){
              echo "<script>alert('系统已存在<$name>name!');window.history.go(-1);</script>";
              return;
            }elseif($flag == 2){
              echo "<script>alert('系统已存在<$action>action!');window.history.go(-1);</script>";
              return;
            }

            $power->powers[$size]['options'][count($power->powers[$size]['options'])] = $option;
            break;

          }

          $size++;
        }

        // echo "options : ".print_r($power->powers);
        echo "<hr>";
        echo "<br> appId : $appId";
        echo "<br> pid : $pid";
        echo "<br> name : $name";
        echo "<br> action : $action";

        $power->save();
        echo "<br>add option successfully";

        header("location: /Faeva/admin/power/index");
      }else{
        $this->view->pid = $pid;
        // header("location: /Faeva/admin/power/addOption/$pid?pid=$pid");
      }
    }



    public function indexAction(){
      $appId = $this->session->get("appId");
      $query = [];
      $query["appId"] = "A123";

      $power = Power::findFirst(array($query));

      $this->view->power = $power;
      echo "yes";
    }

    public function testAction(){
      echo "yse Your are add successfully...";
    }



    public function addAction(){
      if($this->request->isPost()){
          $post = $this->request->getPost();
          $appId = $this->session->get("appId");
          $powername = $post['powername'];
          $controller = $post['controller'];

          echo "<br>powername-- : $powername<br>";
          echo "controller-- : $controller<br>";

          $optionName = $post["name"];
          $action = $post['action'];


          $query = [];
          $query['appId'] = $appId;
          $power = Power::findFirst(array($query));

          $flag = 0;
          foreach($power->powers as $pow){
            if($pow['name'] === $powername){
              $flag = 1;
              break;
            }else if($pow['controller'] === $controller){
              $flag = 2;
              break;
            }
          }

          if($flag === 1){
            echo "<script>alert('系统已存在<$powername>权限名!');window.history.go(-1);</script>";
          }else if($flag === 2){
            echo "<script>alert('系统已存在<$controller>controller!');window.history.go(-1);</script>";
          }else{
            echo "<br>ok ...";

            $p = [];
            $p['name'] = $powername;
            $p['pid'] = GlobalUtil::uuid();
            $p['controller'] = $controller;
            $p['options'] = array();
            $p['options'][0]['oid'] = GlobalUtil::uuid();
            $p['options'][0]['action'] = $action;
            $p['options'][0]['name'] = $optionName;

            $power->powers[count($power->powers)] = $p;
            echo "<br><hr>";
            echo "powers : -- ".count($power->powers);
            echo "<br>";
            $power->save();
          }

          if($power == null){
            echo "ok ...";
          }else{
            echo "powername is exist, please input other powername";
          }
          echo "<br>flag : $flag";
          if($flag === 1 || $flag === 2){
            $this->view->pick("");
          }else{
            header("location: /Faeva/admin/power/index");
          }
      }else{
      }
    }

    public function deleteAction($id){
      echo "PowerController delete";
      echo "id : $id<br>";

      $appId = $this->session->get("appId");

      $query = [];
      $query["appId"] = $appId;
      $power = Power::findFirst(array($query));


      // echo "<br>powers type : ".print_r($power->powers);
      $arr = $power->powers;
      $size = 0;
      foreach($arr as $pow){
        if($pow['pid'] === $id){
          array_splice($arr,$size,1);
          //unset($arr[$size]); //这种方式删除数组元素后的游标不会重新排序,解决方法在上面
          break;
        }
        $size++;
      }

      $power->powers = $arr;
      $power->save();

      header("location: /Faeva/admin/power/index");
    }




    /**
    * 获取appId的所有权限名
    */
    public function getPowersNameAction($appId){
        $query = [];
        $query["appId"] = $appId;
        $powersName = Power::find(array(
              "conditions" => $query,
              "fields" => array('powers.name' => true)
            ));
        echo GlobalUtil::toJsonStr($powersName);
    }

    /**
    * 默认是根据appId来查询
    */
    public function findAction($pid){
          $query = [];
          $query["powers.pid"] = $pid;
          $power = Power::findFirst(array($query));

          $this->view->power = $power;
          //header("location: /faeva.com/bui/Power/index.php");
    }
    public function findByNameAction(){

    }
  }

?>
