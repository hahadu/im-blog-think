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
 *  | Description:   BlogPic
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Models;


use Hahadu\ThinkBaseModel\BaseModel;

class BlogPic extends BaseModel
{
    // 传递aid获取第一条数据作为文章的封面图片
    public function getDataByAid($aid){
        $data=$this::field('path')
            ->where(array('aid'=>$aid))
            ->order('ap_id','asc')
            ->limit(1)
            ->select();
        if(isset($data[0])){
            return $data[0]['path'];
        }
    }
    /**
     * 添加数据
     * @param strind $aid 文章id
     * @param array $image_path 图片路径
     */
    public function addData($data){
        $image_path = $data['image_path'];
        $aid = $data['aid'];
        foreach ($image_path as $k => $v) {
            $pic_data=array(
                'aid'=>$aid,
                'path'=>$v,
            );
            $this::create($pic_data);
        }
        return true;
    }



}