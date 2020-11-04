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
 *  | Date: 2020/10/24 上午9:01
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Models;


use think\Model;

class BlogPic extends Model
{
    // 传递aid获取第一条数据作为文章的封面图片
    public function getDataByAid($aid){
        $data=$this::field('path')
            ->where(array('aid'=>$aid))
            ->order('ap_id','asc')
            ->limit(1)
            ->select();
        return $data[0]['path'];
    }


}