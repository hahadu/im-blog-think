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
 *  | Date: 2020/11/4 下午5:03
 *  +----------------------------------------------------------------------
 *  | Description:   Category
 *  +----------------------------------------------------------------------
 **/

namespace app\admin\controller;

use Hahadu\ImBlogThink\Controller\BaseBlogAdminCategoryController;
use think\App;
use think\facade\View;

class CategoryController extends BaseBlogAdminCategoryController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','分类管理');
    }
    public function index(){
        $assign = parent::category_list();
        return view('',$assign);
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