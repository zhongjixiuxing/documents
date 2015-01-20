<?php
namespace User\Controllers;

use Phalcon\Mvc\Controller,
      Phalcon\Exception;
/**
*
*   要完整实现https请求，还需要依靠SSL， 就要有CA证书，
*     这个要用到钱来买的...oh..ohoh..
*
*/
class HttpsController extends Controller{

    /***
    *  这个函数已经实现了https的请求，
    *   有点奇怪的是， php服务器自动帮你开启了，
    *    后面的原理我就不想去追究了，能用就好，
    *
    */
    public function testHttpsAction(){
      //http转化为https
      if ($_SERVER["HTTPS"]<>"on"){
        $xredir="https://".$_SERVER["SERVER_NAME"].
        $_SERVER["REQUEST_URI"];
        echo "ok...";
        header("Location: ".$xredir);
      }
    }

    public function testHttps2Action(){
      if ($_SERVER["HTTPS"]=="on"){
        $xredir="http://".$_SERVER["SERVER_NAME"].
        $_SERVER["REQUEST_URI"];
        header("Location: ".$xredir);
      }
    }

}
