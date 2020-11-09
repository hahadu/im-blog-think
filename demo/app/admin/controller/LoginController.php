<?php
declare (strict_types = 1);

namespace app\admin\controller;
use Hahadu\ThinkUserLogin\controller\BaseLoginController;
use think\facade\View;
use think\facade\Db;

class LoginController extends BaseLoginController
{
    public function __construct()
    {
        parent::__construct();
        View::assign('title','管理员登录面板');
    }
    public function index()
    {
        return view();
    }
    public function login()
    {
        $result = parent::login();
        if($result == 100003){
            $jumpUrl = '/admin/index/index';
        }else{
            $jumpUrl = '/admin/login/index';
        }
        return jump_page($result,$jumpUrl);
    }
    public function logout()
    {
        $result = parent::logout();
        $jumpUrl = ($result == 100004)?'/admin/login/index':'/admin/index/index';
        return jump_page($result,$jumpUrl);
    }



}
