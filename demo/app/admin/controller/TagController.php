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
 *  | Date: 2020/11/4 下午2:45
 *  +----------------------------------------------------------------------
 *  | Description:   Tag
 *  +----------------------------------------------------------------------
 **/

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseController;
use Hahadu\ImBlogThink\Controller\BaseBlogTagAdminController;
use think\App;
use think\facade\View;

class TagController extends BaseBlogTagAdminController
{
    protected $tag;
    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','标签管理');
    }
    public function index(){
        $assign=parent::tag_list();
        return view('',$assign);
    }

    public function add()
    {
        $result =  parent::add();
        return jump_page($result);
    }
    public function delete($tid)
    {
        $result =  parent::delete($tid);
        return jump_page($result);
    }
    public function edit()
    {
        $result = parent::edit();
        return jump_page($result);
    }


}