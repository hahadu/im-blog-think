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
 *  | Date: 2020/11/4 下午5:43
 *  +----------------------------------------------------------------------
 *  | Description:   Tag
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Models;
use Hahadu\ImBlogThink\Models\BlogTag;
use Hahadu\ThinkBaseModel\BaseModel;

class Tag extends BaseModel
{
    // 添加标签
    public function addData($post){
        $str=$post['tname'];
        if(empty($str)){
            return '标签名不能为空';
        }else{
            $str=nl2br(trim($str));
            $tnames=explode("<br />", $str);
            foreach ($tnames as $k => $v) {
                $v=trim($v);
                if(!empty($v)){
                    $data['tname']=$v;
                    $this->save($data);
                }
            }
            return true;
        }

    }

    // 修改数据
    public function editData($map,$data){
        if(empty($data)){
            $this->error='标签名不能为空';
            return false;
        }else{
            return $this->where(array('tid'=>$data['tid']))->save($data);
        }
    }

    // 根据tid获取单条数据
    public function getDataByTid($tid,$field='all'){
        if($field=='all'){
            return $this->where(array('tid'=>$tid))->find();
        }else{
            return $this->getFieldByTid($tid,'tname');
        }
    }

    /**
     * 获取tname
     * @param array $tids 文章id
     * @return array $tnames 标签名
     */
    public function getTnames($tids){
        foreach ($tids as $k => $v) {
            $tnames[]=$this->where(array('tid'=>$v))->getField('tname');
        }
        return $tnames;
    }


    //获得全部数据
    public function getAllData(){
        $data=$this::select();
        foreach ($data as $k => $v) {
            $data[$k]['count']= \Hahadu\ImBlogThink\Models\BlogTag::where(array('tid'=>$v['tid']))->count();
        }
        return $data;
    }


}