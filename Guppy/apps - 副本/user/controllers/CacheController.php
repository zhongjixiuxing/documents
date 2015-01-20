<?php
namespace User\Controllers;

use Phalcon\Mvc\Controller,
      User\Models\User,
      Phalcon\Exception;
/**
*
*  这个filter 有那么的一点点意义container
*
*/
class CacheController extends Controller{

    public function cacheFrontendAction(){
      //Create an Output frontend. Cache the files for 2 days
      $frontCache = new \Phalcon\Cache\Frontend\Output(array(
          "lifetime" => 172800
      ));

      //生成缓存目录（注册）
      $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
          "cacheDir" => "../cache/"
      ));

      // Get/Set the cache file to ../app/cache/my-cache.html
      $content = $cache->start("my-cache.html");

      // If $content is null then the content will be generated for the cache
      if ($content === null) {
          //Print date and time
          echo date("r");

          //Generate a link to the sign-up action
          echo \Phalcon\Tag::linkTo(
              array(
                  "user/signup",
                  "Sign Up",
                  "class" => "signup-button"
              )
            );
          // Store the output into the cache file
          $cache->save();  //见证奇迹的时刻来了，就这样在cache目录下面就有了my-cache.html文件存在。。
      } else {
          // Echo the cached output
          echo $content;  //如果缓存存在，则直接将缓存输出
      }
    }


    public function cacheBackendAction(){
      // Cache the files for 2 days using a Data frontend
        $frontCache = new \Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 172800
        ));

        // Create the component that will cache "Data" to a "File" backend
        // Set the cache file directory - important to keep the "/" at the end of
        // of the value for the folder
        $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
            "cacheDir" => "../cache/"
        ));

        // Try to get cached records
        $cacheKey = 'user_psws.cache';   //缓存的文件名
        $users    = $cache->get($cacheKey);
        if ($users === null) {
            // $robots is null because of cache expiration or data does not exist
            // Make the database call and populate the variable
            $users = User::find(array("pwd" => "123123"));  //将所有密码为123123的用户找到

            // Store it in the cache
            $cache->save($cacheKey, $users);
            echo "<br> 用户的数据不在后台缓存器中， 现在已经保存到后台缓存中了， 你可以安心....";
        }

        // Use $robots :)
        foreach ($users as $user) {
           echo $user->name, "\n";
        }
    }

}
