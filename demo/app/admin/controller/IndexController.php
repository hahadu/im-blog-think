<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/9/19 下午10:00
 *  +----------------------------------------------------------------------
 *  | Description:   cooleAdmin
 *  +----------------------------------------------------------------------
 **/

declare (strict_types = 1);

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseController;
use think\facade\View;
class IndexController extends AdminBaseController
{
    public function initialize(){
        parent::initialize();
    }
    public function index()
    {
        View::assign('title','后台首页');
        return view('index/index_adminLte');
    }
    public function welcome(){
        return '';
    }


}
