<?php
  namespace Admin\Controllers;
    class GlobalUtil {
      /**
      * 根据时空的分布生成一个32位随机uuid
      */
      public static function uuid(){
    		if (function_exists('com_create_guid')){
    	        return com_create_guid();
    	    }else{
    	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    	        $charid = strtoupper(md5(uniqid(rand(), true)));
    	        $hyphen = chr(45);// "-"
    	        $uuid =
    	                substr($charid, 0, 8).
    	                substr($charid, 8, 4).
    	                substr($charid,12, 4).
    	                substr($charid,16, 4).
    	                substr($charid,20,12);
    	        return $uuid;
    	    }
    	}

    //   /**
    //   * 根据cursor获取json 字符串
    //   */
    //   public function toJsonStr($cursor){
    //
    //     $jsonStr = json_encode($cursor);
    //     $jsonObj = json_decode($jsonStr, true);
    //     $result = json_encode($jsonObj);
    //
    //     return $result;
    //   }
    }

?>
