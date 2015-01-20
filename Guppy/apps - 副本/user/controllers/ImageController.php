<?php
namespace User\Controllers;

  use Phalcon\Mvc\Controller,
      Phalcon\Exception;

/**
*   Role Controller
*       1、本控制类提供角色的增删改查动作
*
*/
  class ImageController extends Controller{
    /**
    * 输出图片到客户端
    */
    public function getImageAction($name){
      if(!$this->request->isPost()){
        $this->response->setHeader("Content-Type", "image/jpeg");
        $uploaddir = $_SERVER['DOCUMENT_ROOT']."/imageDir/";
        $uploaddir.=$name;
        $im = imagecreatefromjpeg($uploaddir);  //加载image到内存上
        if($im){
          imagejpeg($im); //将图片输出到客户端；
        }else{
          throw new Exception("客户端提供的文件名<$name> 加载失败！");
        }
      }else{
        echo "please use get mothod";
      }
    }

    public function showImageAction(){}

    //使用缓存的方式保存一条字符串到临时的缓存目录中
    public function insertMsgToCache($msg){
      $frontCache = new \Phalcon\Cache\Frontend\Data(array(
          "lifetime" => 172800
      ));
      $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
          "cacheDir" => "../cache/test/"
      ));

      $cacheKey = 'index.cache';
      $users    = $cache->get($cacheKey);
      if ($users === null) {
          $cache->save($cacheKey,$msg);
      }
    }

    public function upLoadAction(){
      if($this->request->isPost()){
          if(!empty($_FILES["image_file"])){
            $this->insertMsgToCache("image_file");
            $post = $this->request->getPost();
            $uploaddir = $_SERVER['DOCUMENT_ROOT']."/imageDir/";
            $uploaddir.= $_FILES['image_file']['name'];
            if(move_uploaded_file($_FILES["image_file"]["tmp_name"] , $uploaddir)) {
              echo '{{"result":"ok"}}';
            }else{
              print_r($_FILES);
              throw new Exception("image save 失败..");
            }
          }else{
            $this->insertMsgToCache("no");
          }
        $this->view->disable();

    }else{
      $this->insertMsgToCache("get");
    }
  }
    //使用ajax来上传图片文件
    public function upLoadForJsAction(){
    }

    public function upLoadImageAction(){
      if($this->request->isPost()){
          if(!empty($_FILES["image_file"]))  {
            $post = $this->request->getPost();
            $x1 = $post['x1']; //获取左上角坐标
            $y1 = $post['y1'];
            $x2 = $post['x2']; //获取用户要截取图片的大小
            $y2 = $post['y2'];

            echo "<br> post : ";
            print_r($post);
            echo "<br> files : ".$_FILES['image_file']['name'];
            print_r($_FILES);

            $uploaddir = $_SERVER['DOCUMENT_ROOT']."/imageDir/";

            $uploaddir.= $_FILES['image_file']['name'];

            if(move_uploaded_file($_FILES["image_file"]["tmp_name"] , $uploaddir)) {
              $resizeImage = $this->di->get("resizeImage");

              $xx1 =  floor((int)$x1);
              $yy1 =  floor((int)$y1);
              $xx2 =  floor((int)$post['w']);
              $yy2 =  floor((int)$post['h']);
              $resizeImage->setXy("$xx1", "$yy1");

              $resizeImage->cut($uploaddir, $xx1, $yy1, $xx2, $yy2, $_SERVER['DOCUMENT_ROOT']."/imageDir/"."test2.jpg");
              // $resizeImage->myresizeimage($uploaddir, $corner, "$xx2", "$yy2", "1", "6", "0");

              echo "<br>x2 : $x2";
              echo "<br>y2 : $y2";
            }else{
              print_r($_FILES);
            }
          }
        $this->view->disable();
      }else{

      }
    }
  }
