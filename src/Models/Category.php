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
 *  | Date: 2020/11/4 下午5:44
 *  +----------------------------------------------------------------------
 *  | Description:   Category
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Models;
use Hahadu\DataHandle\Data;
use Hahadu\ThinkBaseModel\BaseModel;

class Category extends BaseModel
{
    //根据cid和field获取对应的数据
    public function getDataByCid($cid,$field='all'){
        $map = ['cid'=>$cid];
        if($field=='all'){
            return $this::where($map)->find();
        }else{
            return $this::where($map)->column($field);
        }
    }
    //获取菜单数据
    public function getAllData($field='all',$type='tree'){
        if($field=='all'){
            $result=$this->getTreeData($type,'order_by','cname','cid','pid');
        }else{
            $result = $this->column("cid,$field");
        }
        return $result;
    }

    // 根据cid获得所有子栏目
    public function getChildData($cid){
        $data=$this->getAllData('all',false);
        $child=Data::channelList($data,$cid);
        foreach ($child as $k => $v) {
            $childs[]=$v['cid'];
        }
        return $childs;
    }


}