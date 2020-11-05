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
 *  | Date: 2020/11/4 下午6:38
 *  +----------------------------------------------------------------------
 *  | Description:   Category
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Controller;


use Hahadu\ImAdminThink\controller\AdminBaseController;
use Hahadu\ImBlogThink\Models\Category;
use think\App;

class BaseBlogAdminCategoryController extends AdminBaseController
{
    protected $category;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->category = new Category();
    }
    public function category_list(){
        $list = $this->category->getAllData();
        $result = [
            'category_list' => $list
        ];
        return $result;
    }
    /****
     * 菜单排序
     * @return string
     */
    public function order_by(){
        if(request()->isPost()){
            $data=$this->request->post();
            $order_status=$this->category->orderData($data,'cid');
            if($order_status){
                $result= 100011;
            }else{
                $result= 400001;
            }
        }else{
            $result = 0;
        }
        return $result;
    }
    /****
     * 添加菜单
     * @return string
     */
    public function add(){
        if(request()->isPost()){
            $data=$this->request->post();
            $add_data=$this->category->addData($data);
            if($add_data>0){
                $result = 100012;
            }else{
                $result = 420001;
            }
            return $result;
        }
        return 0;
    }
    /****
     * 编辑
     * @return bool|int
     */
    public function edit(){
        if(request()->isPost()){
            $data=$this->request->post();
            $id =[ 'cid'=>$data['cid']];
            return $this->category->editData($id,$data);
        }
        return 0;
    }

    /****
     * 删除
     * @return bool|int
     */
    public function delete(){
        if(request()->isGet()){
            $data['cid'] = request()->param('cid');
            return $this->category->deleteData($data);
        }
        return 0;
    }



}