<?php


class ControllerReflection extends ReflectionClass{
    private $controllers = [];

     function __construct(){
        $this->updateControllers();
     }

    /**
    * 根据controller name 获取 controller Reflection class
    */
    public function getClass($name){

      if(isset($this->controllers) && count($this->controllers)>0){
        if(isset($this->controllers[$name])){
          $cname = $this->controllers[$name];
          return new ReflectionClass("Admin\\Controllers\\".$cname);
        }
      }
    }

    //见名知意
    public function getControllers(){
      return $this->controllers;
    }

    //见名知意
    public function updateControllers(){
      $conts = $this->getConts();
      foreach($conts as $cont){
        $this->controllers[$cont] = ucfirst($cont)."Controller";
      }
    }

    /**
    * 获取模块中的All controller name
    */
    public function getConts(){
      //打开 controllers 文件夹，遍历所有的controllers
      $dir = opendir("../apps/admin/controllers");
      $prec = [];
      while (($file = readdir($dir)) !== false)
      {
        if($file !== ".." && $file !== "."){
          if(strpos($file, "Controller") > 0){
            $index = strpos($file, "Controller");
            $file = substr($file, 0, $index);
            $file = lcfirst($file);
            $prec[count($prec)] = $file;
          }
        }
      }
      closedir($dir);
      return $prec;
    }
}
?>
