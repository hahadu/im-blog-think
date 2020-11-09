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
 *  | Date: 2020/9/20 下午3:41
 *  +----------------------------------------------------------------------
 *  | Description:   cooleAdmin 前台导航控制
 *  +----------------------------------------------------------------------
 **/

declare (strict_types = 1);

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseController;
use think\App;
use think\facade\View;
use think\Request;

class HomeNavController extends AdminBaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','前台导航管理');
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

}
