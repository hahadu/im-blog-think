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
 *  | Date: 2020/10/5 下午3:27
 *  +----------------------------------------------------------------------
 *  | Description:   ImAdminThink
 *  +----------------------------------------------------------------------
 **/

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseGroupController;
use think\App;
use think\facade\View;


class GroupController extends AdminBaseGroupController
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','用户组管理');

    }
    public function group()
    {
        $result = parent::base_group_list();
        return view('',$result);
    }

    public function add_group()
    {
        $result = parent::base_add_group();
        if ($result) {
            return jump_page(100012);
        }else{
            return jump_page(420001);
        }
    }

    public function edit_group()
    {
        $result = parent::base_edit_group();
        if ($result) {
            return jump_page(100011);
        }else{
            return jump_page(420011);
        }
    }

    public function delete_group($id)
    {
        $result = parent::base_delete_group($id);
        return jump_page($result);
    }

    public function rec_delete_group($id)
    {
        $result = parent::rec_delete_group($id);
        return jump_page($result);
    }
    public function on_delete_group()
    {
        $assign = parent::on_delete_group();
        return view('',$assign);
    }

}