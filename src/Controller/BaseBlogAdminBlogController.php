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
use Hahadu\Helper\StringHelper;
use Hahadu\ImAdminThink\controller\AdminBaseController;
use Hahadu\ImBlogThink\Models\Blog;
use Hahadu\ImBlogThink\Models\Category;
use Hahadu\ImBlogThink\Models\Comment;
use Hahadu\ImBlogThink\Models\Tag;
use think\App;

class BaseBlogAdminBlogController extends AdminBaseController
{
    protected $blog;
    protected $category;
    protected $tag;
    protected $comment;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->blog = new Blog();
        $this->category = new Category();
        $this->tag = new Tag();
        $this->comment = new Comment();

    }

    /****
     * 文章列表
     * @return array
     */
    public function blog_list(){
       $result = $this->blog->getPageData('all','all','all',15);
       return $result;
    }

    /****
     * 删除文章
     * @return bool|int 状态码
     */
    public function delete(){
        if(request()->isGet()){
            $data['id'] = request()->param('id');
            return $this->blog->deleteData($data);
        }
        return 0;
    }

    /****
     * 添加文章
     * @return int
     */
    public function add(){
        $data = request()->post();
        // 获取post数据
        // 反转义为下文的 preg_replace使用
        $data['content']=htmlspecialchars_decode($data['content']);
        if(isset($data['author'])){
            $data['author'] = get_user('id');
        }
        // 判断是否修改文章中图片的默认的alt 和title
        if(true==config('blog.replace_image_attr')){
            // 修改图片默认的title和alt
            $data['content']=preg_replace('/title=\"(?<=").*?(?=")\"/','title='.config('blog.default_image_title'),$data['content']);
            $data['content']=preg_replace('/alt=\"(?<=").*?(?=")\"/','alt='.config('blog.default_image_alt'),$data['content']);
        }
        if(empty($data['image_path'])) {
            $data['image_path'] = StringHelper::get_all_pic($data['content']);
        }
        // 将绝对路径转换为相对路径
        $data['content']=preg_replace('/src=\"^\/.*\/Upload\/images$/','src="/Upload/images',$data['content']);
        // 转义
        $data['content']=htmlspecialchars($data['content']);
        return $this->blog->addData($data);
    }

    /****
     * @return mixed 已删除的文章列表
     */
    public function on_delete(){
        $delete_list  = $this->blog->selectDelData();
        return $delete_list;
    }

    /****
     * 编辑文章
     * @param int $id 文章id
     * @return bool|int
     */
    public function edit($id){
        // 获取post数据
        $data=$this->request->post();
        $map = [
            'id'=>$id,
        ];
        return $this->blog->editData($map,$data);
    }

    /****
     * 添加文章准备页
     * @return array|string
     */
    public function add_read(){
        $allCategory=$this->category->getAllData();
        if(empty($allCategory)){
            return jump_page(430001);
        }

        $allTag=$this->tag->getAllData();
        return [
            'categorys' => $allCategory,
            'tags' => $allTag,
        ];
    }

    /****
     * 文章编辑页数据
     * @param int $id 文章id
     * @return array
     */
    public function edit_read($id){
        $data=$this->blog->getDataById($id);
        $allCategory=$this->category->getAllData();
        $allTag=$this->tag->getAllData();
        return [
            'data' => $data,
            'categorys' => $allCategory,
            'tags' => $allTag,
        ];
    }

    /****
     * @return array
     */
    public function info(){
        return [
            'all_blog'=>$this->blog->getCountData(), //文章总数
            'delete_blog'=>$this->blog->getCountData([],true), //删除的文章数量
            'hide_blog'=>$this->blog->getCountData(["is_show"=>0]), //隐藏的文章数量
            'all_comment'=>$this->comment->count(),
        ];
    }

}