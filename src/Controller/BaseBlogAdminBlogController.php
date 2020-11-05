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
 *  | Date: 2020/11/5 下午2:13
 *  +----------------------------------------------------------------------
 *  | Description:   blog
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Controller;
use Hahadu\ImAdminThink\controller\AdminBaseController;
use Hahadu\ImBlogThink\Models\Blog;
use Hahadu\ImBlogThink\Models\Category;
use Hahadu\ImBlogThink\Models\Tag;
use think\App;

class BaseBlogAdminBlogController extends AdminBaseController
{
    protected $blog;
    protected $category;
    protected $tag;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->blog = new Blog();
        $this->category = new Category();
        $this->tag = new Tag();
    }

    /****
     * @return array
     */
    public function blog_list(){
       return $this->blog->getPageData('all','all','all',0,15);
    }
    public function delete(){
        if(request()->isGet()){
            $data['id'] = request()->param('id');
            return $this->blog->deleteData($data);
        }
        return 0;
    }

}