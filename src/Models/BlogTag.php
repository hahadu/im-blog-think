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
 *  | Date: 2020/10/24 上午1:01
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Models;
use Hahadu\ThinkBaseModel\BaseModel;
use think\facade\Db;
use think\Model;


class BlogTag extends Model
{
    public function getDataByAid($aid,$field='true'){
        if($field=='all'){
            return Db::name('BlogTag')
                ->alias('btag')
                ->join('tag tag ',' btag.tid=tag.tid')
                ->where(array('aid'=>$aid))
                ->select();
        }else{
            return $this::where(array('aid'=>$aid))->column('tid');
        }
    }


}