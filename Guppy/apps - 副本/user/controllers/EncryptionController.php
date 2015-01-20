<?php
namespace User\Controllers;

use Phalcon\Mvc\Controller,
      User\Models\User,
      Phalcon\Exception;
/**
*
*
*/
class EncryptionController extends Controller{

  /**
  *  目前就是用phalcon Crypt默认的加密方式,有需求在根据实际上的来办
  */
  public function indexAction(){
      $crypt = new \Phalcon\Crypt();
      $key = 'le password';
      $text = 'This is a secret text';
      echo "<br>加密字符串：$text";
      $encrypted = $crypt->encrypt($text, $key);
      echo "<br>加密后的字符串: $encrypted";
      echo "<br>解密后的字符串：";
      echo $crypt->decrypt($encrypted, $key);
  }

}
