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
 *  | Date: 2020/11/4 下午6:16
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Controller;
use think\App;
use think\facade\Db;


class BaseBlogHomeController extends BaseBlogController
{
    // 文章内容
    public function detail($id){
        $id = (int)$id;
        $cid=intval(cookie('cid'));
        $tid=intval(cookie('tid'));
        $search_word=cookie('search_word');
        $search_word=empty($search_word) ? 0 : $search_word;
        $click=cookie_array('click');
        // 判断是否已经记录过id
        if (null!=$click && array_key_exists($id, $click)) {
            // 判断点击本篇文章的时间是否已经超过一天
            if ($click[$id]-time()>=86400) {
                $click[$id]=time();
                // 文章点击量+1
                Db::name('blog')
                    ->where(array('id'=>$id))
                    ->inc('click',1)
                    ->update();
            }
        }else{
            $click=[
                $id => time(),
            ];
            cookie_array('click',$click,864000);
            // 文章点击量+1
            Db::name('blog')
                ->where(array('id'=>$id))
                ->inc('click',1)
                ->update();
        }
        switch(true){
            case $cid==0 && $tid==0 && $search_word==(string)0:
                $map=array();
                break;
            case $cid!=0:
                $map=array('cid'=>$cid);
                break;
            case $tid!=0:
                $map=array('tid'=>$tid);
                break;
            case $search_word!==0:
                $map=array('title'=>$search_word);
                break;
        }
        // 获取文章数据
        $article=$this->blog->getDataById($id,$map);
        // 如果文章不存在；则返回404页面
        if (empty($article['current']['id'])) {
            $result = 404;
        }else{
            // 获取评论数据
            $comment=$this->comment->getChildData($id);
            $result=array(
                'article'=>$article,
                'comment'=>$comment,
                'cid'=>$article['current']['cid']
            );
            if (!empty(session('user.id'))) {
                $result['user_email']=Db::name('users')->getFieldById(session('user.id'),'email');
            }
        }
        return $result;
    }
    // 标签
    public function tag($tid){
        // 获取标签名
        $tname=$this->tag->getFieldByTid($tid,'tname');
        // 如果标签不存在；则返回404页面
        if (empty($tname)) {
            $result = 404;
        }else{
            // 获取文章数据
            $articles=$this->blog->getPageData('all',$tid);
            $result =array(
                'list'=>$articles['list'],
                'page'=>$articles['page'],
                'title'=>$tname,
                'title_word'=>'与<span class="accent">'.$tname.'</span>标签相关的文章',
                'cid'=>'index'
            );
        }
        return $result;
    }

    // 站内搜索
    public function search($search){
        $articles=$this->blog->getDataByTitle($search);
        $result=array(
            'list'=>$articles['list'],
            'page'=>$articles['page'],
            'title'=>$search,
            'title_word'=>'与<span class="accent">'.$search.'</span>相关的文章',
            'cid'=>'index'
        );
        return $result;
    }
    //发表评论
    public function comment(){
        $data=$this->request->post();
        switch (true){
            case empty($data['content']): //内容为空
                $result = 420003;
                break;
            case empty(get_uid()): //未登录
                $result = 420102;
                break;
            case !empty(get_uid())&&!empty($data['content']):
                $result = $this->comment->addData(1);
                break;
            default :
                $result = 0;
                break;
        }
        return $result;
    }
    // 文章分类
    public function category($cid){
        // 获取分类数据
        $category=$this->category->getDataByCid($cid);
        // 如果分类不存在；则返回404页面
        if (empty($category)) {
            $result = 404;
        }else{
            // 获取分类下的文章数据
            $articles=$this->blog->getPageData($cid);
            $result=array(
                'category'=>$category,
                'list'=>$articles['list'],
                'page'=>$articles['page'],
                'cid'=>$cid
            );
        }
        return $result;
    }



}