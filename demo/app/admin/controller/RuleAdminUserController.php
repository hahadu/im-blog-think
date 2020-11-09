<?php
declare (strict_types = 1);

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseRuleUserController;
use think\App;
use think\facade\View;
use think\facade\Request;

class RuleAdminUserController extends AdminBaseRuleUserController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','管理员列表');
    }


    public function admin_list()
    {
        $assign = parent::admin_list();
        $group_data = $this->auth_group->select();
        $assign['groupData'] = $group_data;
        return view('',$assign);
    }

    /****
     * 添加管理员
     * @return \think\response\View
     */
    public function add_admin(){
        if(Request::isPost()){
            $result = parent::add_admin();
            return jump_page($result);

        }else{
            $assign = parent::add_admin();
            return view('',$assign);
        }
    }

    /**
     * 修改管理员
     */
    public function edit_admin($id){
        if(request()->isPost()){
            $result = parent::edit_admin($id);
            if($result){
                return jump_page('1');
            }else{
                return jump_page('0');
            }
        }else{
            $result = parent::edit_admin($id);
            return view('',$result);
        }
    }

}
