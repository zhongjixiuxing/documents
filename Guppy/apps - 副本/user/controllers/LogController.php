<?php
namespace User\Controllers;

  use Phalcon\Mvc\Controller,
      Phalcon\Logger\Adapter\File as LogFile,
      Phalcon\Logger\Formatter\Line as LineFormatter,
      Phalcon\Logger\Adapter\Syslog as SyslogAdapter,
      Phalcon\Exception;

/**
*   phalcon 有四种日志的方式
*     1、File 保存日志到普通文件中 Phalcon\Logger\Adapters\File
*     2、Stream 保存日志到php流中 Phalcon\Logger\Adpaters\Stream
*     3、Syslog 保存日志到系统日志中 Phalcon\Logger\Adpaters\Syslog
*
*/
  class LogController extends Controller{

    /**
    * 下面演示的是生成几条log信息保存到指定的log文件中；
    *　  这是多么的好用呀，thanks for phalcon projecters, i am like your project
    *
    */
    public function logAction(){
      $log =  new LogFile("../log/test.log");
      $log->log("this is test log one");
      $log->log("this is test log two");
      $log->log("this is test log three");
      $log->error("test is test log error");
    }

    /**
    *
    * 按照官网上的说法， 保存log文件的操作的一件非常消耗资源的操作，
    *  可以使用事务的方式， 将数据先放在内存中，然后一次性进行文件操作，
    *   这样的文件执行效率会更加的高
    */
    public function logTransactionAction(){

      $log =  new LogFile("../log/test.log");
      $log->begin();  //开启事务
      $log->log("this is test log one");
      $log->alert("this is test log alert");
      $log->log("this is test log three");
      $log->error("test is test log error");

      $log->commit();
    }

    /**
    *  自定义日期的保存格式
    *    其实默认的看起来也挺伺服的
    */
    public function logFormatAction(){
      $log =  new LogFile("../log/test.log");

      // 修改日志格式
      $formatter = new LineFormatter("%date% - %message%");
      $log->setFormatter($formatter);

      $log->log("this is log info");
      $log->error("test is test log error");
    }

    /**
    *  使用系统日志的方式, 其他的暂时不会去接触他们
    */
    public function logSysAction(){
      // 基本用法
      $logger = new SyslogAdapter(null);

      // Setting ident/mode/facility 参数设置
      $logger = new SyslogAdapter("ident-name", array(
          'option' => LOG_NDELAY,
          'facility' => LOG_MAIL
      ));

      $logger->log("yes , this syslog");
    }

  }
