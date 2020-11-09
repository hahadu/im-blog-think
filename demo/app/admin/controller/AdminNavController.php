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

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseNavController;
use think\App;
use think\facade\View;
class AdminNavController extends AdminBaseNavController{
    protected $jumpUrl = 'admin/admin_nav/index';
    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign("title","后台菜单管理");
    }
    public function index(){
        $assign = [
            'AdminNav' => $this->adminNavTree(),
        ];
        return View('',$assign);
    }
    public function order_by()
    {
        $result = parent::order_by();
        return jump_page($result);
    }
    public function add()
    {
        $result = parent::add();
        return jump_page($result);
    }
    public function edit()
    {
        $result = parent::edit();
        return jump_page($result);
    }
    public function delete()
    {
        $result = parent::delete();
        return jump_page($result);
    }

}
