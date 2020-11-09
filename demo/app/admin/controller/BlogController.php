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
 *  | Date: 2020/11/5 下午2:06
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/

namespace app\admin\controller;
use Hahadu\ImBlogThink\Controller\BaseBlogAdminBlogController;
use Hahadu\ImBlogThink\Models\Comment;
use Hahadu\ThinkUeditor\ThinkUeditor;
use think\App;
use think\facade\View;

class BlogController extends BaseBlogAdminBlogController
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        View::assign('title','文章管理');
    }
    public function index(){
        $assign = parent::blog_list();
/*        dump($this->info());
        dump($this->on_delete());*/
        return view('',$assign);
    }
    public function add()
    {
        if(is_post()){
            $result = parent::add();
            return jump_page($result);
        }else{
            $assign = parent::add_read();
            return view('',$assign);
        }
    }

    public function delete(){
        $result = parent::delete();
        return jump_page($result);
    }
    public function edit($id){
        if(is_post()){
            $result = parent::edit($id);
            return jump_page($result);
        }else{
            $assign = parent::edit_read($id);
            return view('',$assign);
        }

    }
    public function ueditor(){
        echo ueditor();
        die;
    }


}