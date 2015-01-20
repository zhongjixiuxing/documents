<?php
namespace User\Controllers;

use User\Models\QQUser,
    User\Models\AppUser as AppUser,
    User\Models\Account as Account,
    User\Auth\Exception,
    Phalcon\Logger\Adapter\File as LogFile,
    User\Controllers\BaseController;

/**
*  User Manage Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class ProductController extends BaseController  {

    public function commitAction(){}
}
