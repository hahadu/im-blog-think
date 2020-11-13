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
 *  | Date: 2020/11/4 下午5:51
 *  +----------------------------------------------------------------------
 *  | Description:   微信公众平台SDK
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Controller;
use app\BaseController;
use Hahadu\ImBlogThink\Models\Blog;
use Hahadu\ImBlogThink\Models\Comment;
use Hahadu\ImBlogThink\Models\Link;
use think\App;
use Hahadu\ImBlogThink\Models\Category;
use Hahadu\ImBlogThink\Models\Tag;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;

class BaseBlogController extends BaseController
{
    protected $category; //分类
    protected $tag; //标签
    protected $link; //友链
    protected $comment; //评论
    protected $blog;

    /****
     * 获取常用数据
     * @return array
     */
    protected function get_home_info(){
        return array(
            'categorys'=>$this->category->getAllData('all','level'),
            'tags'=>$this->tag->getAllData(),
            'links'=>$this->link->getDataByState(0,1),
            'recommend'=>$this->getRecommend(),
            'new_comment'=>$this->get_new_comment(),
            'hot_article'=>$this->getHotArticle(5),
            'show_link'=>$this->is_show_link(),
        );
    }
    protected function initialize()
    {
        parent::initialize();
        $this->category = new Category();
        $this->tag = new Tag();
        $this->link = new Link();
        $this->comment = new Comment();
        $this->blog = new Blog();
    }

    /****
     * 获取置顶文章
     * @return mixed
     */
    protected function getRecommend(){

        return $this->blog->getRecommend();

    }

    /*****
     * 获取热门文章
     */
    protected function getHotArticle($limit = 5){

        return $this->blog->hotArticle($limit);

    }

    /****
     * 获取最新评论
     * @return mixed
     */
    protected function get_new_comment(){

        return $this->comment->getNewComment();

    }

    /*****
     * 断是否显示友情链接
     * @return bool
     */
    protected function is_show_link(){

        $info = $this->get_current_url_info();

        // 判断是否显示友情链接
        return $info['action_name']=='index' && $info['controller_name'] == "index";

    }

    /****
     * 获取当前url信息
     */
    protected function get_current_url_info(){

        $root_name = parse_name(Request::rootUrl()); //应用名

        $root_name = str_replace('/','',$root_name);

        $controller_name = parse_name(Request::controller()); //控制名

        $action_name = parse_name(Request::action());   //操作名

        return compact("root_name","controller_name","action_name");
    }


}