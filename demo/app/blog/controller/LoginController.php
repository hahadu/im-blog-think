<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu/wechat
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/10/26 下午9:16
 *  +----------------------------------------------------------------------
 *  | Description:   微信公众平台SDK
 *  +----------------------------------------------------------------------
 **/

namespace app\blog\controller;
use app\user\model\Users;
use Hahadu\Helper\StringHelper;
use Hahadu\ThinkUserLogin\controller\BaseLoginController;
use Hahadu\ThinkUserLogin\validate\BaseUserLogin;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;
use think\facade\Session;

class LoginController extends BaseLoginController
{

    public function __construct()
    {
        parent::__construct();
        View::assign('title','用户登录');
    }
    public function index()
    {
        return view();
    }
    public function login()
    {
        $result = parent::login();
        if($result == 100003){
            $jumpUrl = '/blog/index/index';
        }else{
            $jumpUrl = '/blog/login/index';
        }
        return jump_page($result,$jumpUrl);
    }
    public function logout()
    {
        $result = parent::logout();
        $jumpUrl = ($result == 100004)?'/blog/login/index':'/blog/index/index';
        return jump_page($result,$jumpUrl);
    }
    public function register(){
        if(request()->isPost()){
            $result = parent::email_register();
            return  jump_page($result);
        }else{
            return view('');
        }
    }
}