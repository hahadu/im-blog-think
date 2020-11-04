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
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->category = new Category();
        $this->tag = new Tag();
        $this->link = new Link();
        $this->comment = new Comment();
        $this->blog = new Blog();
        // 获取置顶推荐文章
        $recommend=$this->blog->getRecommend();
        $hot_article = $this->blog->hotArticle(5);
        // 获取最新评论
        $new_comment=$this->comment->getNewComment();
        // 判断是否显示友情链接
        $root_name = parse_name(Request::rootUrl()); //应用名
        $controller_name = parse_name(Request::controller()); //控制名
        $action_name = parse_name(Request::action());   //操作名
        $show_link=($action_name=='index') ? true : false;

        // 分配常用数据
        $assign=array(
            'categorys'=>$this->category->getAllData('all','level'),
            'tags'=>$this->tag->getAllData(),
            'links'=>$this->link->getDataByState(0,1),
            'recommend'=>$recommend,
            'new_comment'=>$new_comment,
            'hot_article'=>$hot_article,
            'show_link'=>$show_link
        );
        return View::assign($assign);

    }

}