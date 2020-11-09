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
 *  | Date: 2020/10/6 上午12:46
 *  +----------------------------------------------------------------------
 *  | Description:   ImAdminThink
 *  +----------------------------------------------------------------------
 **/

namespace app\admin\controller;
use \Hahadu\ImAdminThink\controller\AdminBaseRuleGroupController;
use think\App;
use think\facade\Db;
use think\Request;
use think\facade\View;


class RuleGroupController extends AdminBaseRuleGroupController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','分配权限');
    }

    public function rule_group()
    {
        if(request()->isPost()){
            $result = parent::rule_group();
            if ($result) {
                return jump_page(100011);
            }else{
                return jump_page($result);
            }
        }else{
            $id=request()->get('id');
            // 获取用户组数据
            $result = parent::rule_group_view($id);
            return view('',$result);
        }
    }
    /**
     * 添加成员
     */
    public function check_user(Request $request)
    {
        $assign = parent::base_check_user($request);
        return view('',$assign);
    }


    /****
     * 添加成员到管理组
     */
    public function add_user_from_group(Request $request)
    {
        $result = parent::add_user_from_group($request);
        return jump_page($result);
    }

    /****
     * 将用户移除管理组
     */
    public function delete_user_from_group(Request $request){
        $result= parent::delete_user_from_group($request);
        return jump_page($result);
    }
}