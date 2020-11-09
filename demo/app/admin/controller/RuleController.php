<?php
declare (strict_types = 1);

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseRuleController;
use Hahadu\ImAdminThink\model\AuthGroup;
use Hahadu\ImAdminThink\model\AuthRule;
use Hahadu\ImAdminThink\model\AuthGroupAccess;
use Hahadu\ImAdminThink\model\Users;
use think\App;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;


class RuleController extends AdminBaseRuleController
{
    private $auth_rule;
    private $auth_group;
    private $auth_group_access;
    private $jumpUrlRule = 'admin/rule/index';
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->auth_rule = new AuthRule();
        $this->auth_group = new AuthGroup();
        $this->auth_group_access = new AuthGroupAccess();
       // $this->Users = new Users();

        View::assign('title','权限控制');
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $assign = parent::get_tree_nav();
        return view('',$assign);
    }

    public function add()
    {
        $result = parent::add();
        if ($result>0) {
            return jump_page(100012,$this->jumpUrlRule);
        }else{
            return jump_page(420001,$this->jumpUrlRule);
        }
    }
    public function edit()
    {
        $result =  parent::edit();
        if ($result>0) {
            return jump_page(100011);
        }else{
            return jump_page(420011);
        }
    }
    public function delete($id)
    {
        $result = parent::delete($id);
        if($result){
            return jump_page('100013',$this->jumpUrlRule);
        }else{
            return jump_page(400013,$this->jumpUrlRule);
        }
    }
    public function on_delete_rule()
    {
        $assign = parent::on_delete_rule();
        return view('', $assign);
    }

    public function rec_delete_rule($id)
    {
        $result = parent::rec_delete_rule($id);
        return jump_page($result);

    }
}