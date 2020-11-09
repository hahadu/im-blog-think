<?php
declare (strict_types = 1);

namespace app\admin\controller;
use Hahadu\ImAdminThink\controller\AdminBaseStatusCodeController;
use think\App;
use think\facade\View;
class StatusCodeController extends AdminBaseStatusCodeController
{
    private $jumpUrl = '/admin/status_code/index';
    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','状态码管理');
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $assign = parent::base_status_code_list();
        return view('',$assign);
    }

    /****
     * 显示已删除的数据
     * @return \think\response\View
     */
    public function on_delete(){
        $assign = parent::on_delete();
        return view('', $assign);
    }
    public function rec_delete($id){
        $result = parent::rec_delete($id);
        return jump_page($result);
    }
    public function add()
    {
        $result = parent::add_status_code();
        return  jump_page($result,$this->jumpUrl);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return String
     */
    public function edit()
    {
        if(request()->isPost()){
            $result = parent::edit_status_code();
            return jump_page($result);
        }
    }

    /**
     * 删除状态码
     * @param  int  $id
     * @return String
     */
    public function delete($id)
    {
        if(request()->isGet()){
            $result = parent::delete_status_code($id);
            return jump_page($result);
        }
    }
}
