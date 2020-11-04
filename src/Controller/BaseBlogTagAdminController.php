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
 *  | Date: 2020/11/4 下午6:26
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Controller;


use Hahadu\ImAdminThink\controller\AdminBaseController;
use Hahadu\ImBlogThink\Models\Tag;
use think\App;

class BaseBlogTagAdminController extends AdminBaseController
{
    protected $tag;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->tag = new Tag();
    }

    public function add(){
        $data = request()->post();
        $add_data = $this->tag->addData($data);
        if($add_data>0){
            $result = 100012;
        }else{
            $result = 420001;
        }
        return $result;
    }
    public function delete($tid){
        $map['tid'] = $tid;
        $result = $this->tag->deleteData($map);
        return $result;
    }
    public function edit(){
        $data = request()->post();
        $map = [
            'tid'=> $data['tid'],
        ];
        $edit_status = $this->tag->editData($map,$data);
        switch ($edit_status){
            case 1:
                $result = 100011;
                break;
            default :
                $result = $edit_status;
                break;
        }
        return $result;
    }
    public function tag_list(){
        $tag_list = $this->tag->getAllData();
        $result=[
            'tag_list'=>$tag_list
        ];
        return $result;
    }
}