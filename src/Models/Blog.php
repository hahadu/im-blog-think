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
 *  | Date: 2020/10/24 上午12:34
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Models;
use Hahadu\ImBlogThink\Models\BlogTag;
use Hahadu\ImBlogThink\Models\BlogPic;
use Hahadu\ImBlogThink\Models\Category;
use Hahadu\ThinkBaseModel\BaseModel;
use Hahadu\Helper\DateHelper;
use Hahadu\DataHandle\Data;
use think\facade\Db;
use think\model\concern\SoftDelete;
use Hahadu\Helper\StringHelper;

class Blog extends BaseModel
{
    use SoftDelete;
    protected $createTime = 'create_time';
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = NULL;

    protected $blog_tag;
    protected $blog_pic;
    protected $category;
    public function __construct(array $data = [])
    {
        $this->blog_pic = new BlogPic();
        $this->blog_tag = new BlogTag();
        $this->category = new Category();
        parent::__construct($data);

    }
    // 传递id获取单条全部数据 $map 主要为前台页面上下页使用
    public function getDataById($id,$map=''){
        if($map==''){
            // $map 为空则不获取上下篇文章
            $data=$this->where(array('id'=>$id))->find();
            $data['tids']=$this->blog_tag->getDataByAid($id);
            $data['tag']=$this->blog_tag->getDataByAid($id,'all');
            $data['category']=current($this->category->getDataByCid($data['cid'],'cid,cid,cname,keywords'));
            // 获取相对路径的图片地址
            $data['content']=preg_editor_image_path($data['content']);
        }else{
            if(isset($map['tid'])){
                // 根据此标签tid获取上下篇文章
                $prev_map['at.tid']=$map['tid'];
                $prev_map[]=array('a.is_show'=>1);
                $next_map=$prev_map;
                $prev_map['a.id']=array($id-1);
                $next_map['a.id']=array($id+1);
                $data['prev']=$this->field('a.id,a.title')->alias('a')->join('blog_tag at','a.id=at.aid')->where($prev_map)->limit(1)->find();
                $data['next']=$this->field('a.id,a.title')->alias('a')->join('blog_tag at','a.id=at.aid')->where($next_map)->order('a.id','desc')->limit(1)->find();
            }else if(isset($map['cid'])){
                // 根据此分类cid获取上下篇文章
                $prev_map=$map;
                $prev_map['is_show']=1;
                $next_map=$prev_map;
                $prev_map['id']=$id - 1;
                $next_map['id']=$id + 1;
                $data['prev']=$this->field('id,title')->where($prev_map)->limit(1)->find();
                $data['next']=$this->field('id,title')->where($next_map)->order('id','desc')->limit(1)->find();
            }else{
                // 根据搜索词获取上下篇文章
                $prev_map=(!empty($map['title']))?['title'=>['like','%'.$map['title'].'%']]:[];
                $prev_map['is_show']=1;
                $prev_map['delete_time']=null;
                $next_map=$prev_map;
                $prev_map['id']=array($id - 1);
                $next_map['id']=array($id + 1);
                $data['prev']=$this->field('id,title')->where($prev_map)->limit(1)->find();
                $data['next']=$this->field('id,title')->where($next_map)->order('id','desc')->limit(1)->find();
            }
            // 如果不为空 添加url
            if(!empty($data['prev'])){
                $data['prev']['url']=url('/blog/index/detail',array('id'=>$data['prev']['id']));
            }
            if(!empty($data['next'])){
                $data['next']['url']=url('/blog/index/detail',array('id'=>$data['next']['id']));
            }
            $data['current']=$this->where(array('id'=>$id))->find();
            $data['current']['pic_path']=$this->blog_pic->getDataByAid($id);
            $data['current']['tids']=$this->blog_tag->getDataByAid($id);
            $data['current']['tag']=$this->blog_tag->getDataByAid($id,'all');
            $data['current']['category']=current($this->category->getDataByCid($data['current']['cid'],'cid,cid,cname,keywords'));
            $data['current']['content']=preg_editor_image_path($data['current']['content']);
        }
        return $data;
    }

    public function getPageData($cid='all',$tid='all',$is_show='1',$limit=10){
        if($cid=='all' && $tid=='all'){
            if($is_show=='all'){
                $where=[];
            }else{
                $where=array(
                    'is_show'=>$is_show
                );
            }
            //获取分页数据
            $list=$this->getPageBlogList($where,$limit);
            $extend=array(
                'type'=>'index',
                'id'=>0
            );
        }elseif($cid=='all' && $tid!='all') {
            if($is_show=='all'){
                $where=array(
                    'at.tid'=>$tid,
                );
            }else{
                $where=array(
                    'at.tid'=>$tid,
                    'a.is_show'=>$is_show
                );
            }
            $list=$this->blog_tag
                ->getPageBlogList($where,$limit);
            $extend=array(
                'type'=>'tid',
                'id'=>$tid
            );
        }elseif ($cid!='all' && $tid=='all') {
            // 获取cid下的全部文章
            if($is_show=='all'){
                $where=array(
                    'cid'=>$cid,
                );
            }else{
                $where=array(
                    'cid'=>$cid,
                    'is_show'=>$is_show
                );
            }
            $list=$this
                ->getPageBlogList($where,$limit);
            $extend=array(
                'type'=>'cid',
                'id'=>$cid
            );
        }

        foreach ($list as $k => $v) {
            $list[$k]['tag']=$this->blog_tag->getDataByAid($v['id'],'all')->toArray();
            $list[$k]['pic_path']=$this->blog_pic->getDataByAid($v['id']);
            $list[$k]['category']=current($this->category->getDataByCid($v['cid'],'cid,cid,cname'));
            $v['content']=preg_editor_image_path($v['content']);
            $list[$k]['content']=htmlspecialchars($v['content']);
            $list[$k]['url']=url('/blog/index/detail',array('id'=>$v['id']));
            $list[$k]['extend']=$extend;
        }
        $page = $list->render();
        return [
            'page'=>$page,
            'list'=>$list,
        ];
    }

    /****
     * 阅读量排序
     * @param int $limit 数量
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function hotArticle($limit=10){
       return $this::field('id,title,author,create_time')
            ->order('click','desc')
            ->limit($limit)
            ->select();
    }

    /****
     * 获取置顶文章
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getRecommend(){
        $map=array(
            'is_show'=>1,
            'is_top'=>1,
    //        'delete_time'=>null,
        );
        $recommend = $this::field('id,title,author,create_time')
            ->where($map)
            ->order('id','desc')
            ->select();
        return $recommend;
    }

    // 传递搜索词获取数据
    public function getDataByTitle($search){
        $list=$this
            ->whereLike('title',"%$search%")
            ->order('create_time','desc')
            ->paginate(10);
        foreach ($list as $k => $v) {
            $list[$k]['pic_path']=$this->blog_pic->getDataByAid($v['id']);
            $list[$k]['url']=url('/blog/index/detail',array('search'=>$search,'id'=>$v['id']));
            $list[$k]['tids']=$this->blog_tag->getDataByAid($v['id']);
            $list[$k]['tag']=$this->blog_tag->getDataByAid($v['id'],'all');
            $list[$k]['category']=current($this->getDataByCid($v['cid'],'cid,cid,cname,keywords'));
        }
        $page=$list->render();
        $data=array(
            'page'=>$page,
            'list'=>$list
        );
        return $data;
    }
    // 传递cid获得此分类下面的文章数据
    // is_all为true时获取全部数据 false时不获取is_show为0 和is_delete为1的数据
    public function getDataByCid($cid,$is_all=false){
        if($is_all){
            return $this->order('create_time','desc')->select();
        }else{
            $where=array(
                'cid'=>$cid,
                'is_show'=>1,
                'is_delete'=>0,
            );
            return $this->where($where)->order('create_time','desc')->select();
        }
    }
    public function deleteData($map, $type = false)
    {
        if($type==true){
            $d_aid = [
                'aid'=>$map['id']
            ];
            $this->blog_pic->deleteData($d_aid);
            $this->blog_tag->deleteData($d_aid);
        }
        return parent::deleteData($map, $type);
    }

    protected function getPageBlogList($where,$limit){
        return $this::where($where)
            ->order('create_time','desc')
            ->paginate($limit);
    }

    // 修改数据
    public function editData($map,$data){
        $id=$map['id'];
        // 反转义为下文的 preg_replace使用
        $data['content']=htmlspecialchars_decode($data['content']);
        // 判断是否修改文章中图片的默认的alt 和title
        if(true==config('blog.replace_image_attr')){
            // 修改图片默认的title和alt
            $data['content']=preg_replace('/title=\"(?<=").*?(?=")\"/','title='.config('blog.default_image_title'),$data['content']);
            $data['content']=preg_replace('/alt=\"(?<=").*?(?=")\"/','alt='.config('blog.default_image_alt'),$data['content']);
        }
        // 转换路径
        if(empty($data['image_path'])){
            $data['image_path']=StringHelper::get_all_pic($data['content']);
        }

        $data['content']=preg_replace('/src=\"^\/.*\/Upload\/images$/','src="/Upload/images',$data['content']);
        $data['content']=htmlspecialchars($data['content']);

        if($this::update($data,$map)){
            $aid= ['aid'=>$id];
            $this->blog_tag::where($aid)->delete();
            if(isset($data['tids'])){
                $tag_data = [
                    'aid' => $id,
                    'tids'=>$data['tids'],
                ];
                $this->blog_tag->addData($tag_data);
            }
            $this->blog_pic->deleteData(['aid'=>$id]);
            $pic_data = [
                'aid' => $id,
                'image_path'=> $data['image_path']
            ];
            //添加新图片路径
            $this->blog_pic->addData($pic_data);
            return 100011;
        }else{
            return 420011;
        }
    }

    //添加数据
    public function addData($data){
        // 获取post数据
        // 反转义为下文的 preg_replace使用
        $data['content']=htmlspecialchars_decode($data['content']);
        // 判断是否修改文章中图片的默认的alt 和title
        if(true==config('blog.replace_image_attr')){
            // 修改图片默认的title和alt
            $data['content']=preg_replace('/title=\"(?<=").*?(?=")\"/','title='.config('blog.default_image_title'),$data['content']);
            $data['content']=preg_replace('/alt=\"(?<=").*?(?=")\"/','alt='.config('blog.default_image_alt'),$data['content']);
        }
        if(empty($data['image_path'])) {
            //文章图片
            $data['image_path'] = StringHelper::get_all_pic($data['content']);
        }
        // 将绝对路径转换为相对路径
        $data['content']=preg_replace('/src=\"^\/.*\/Upload\/images$/','src="/Upload/images',$data['content']);
        // 转义
        $data['content']=htmlspecialchars($data['content']);

        if($blog_add= $this::create($data)){
            if($id=$blog_add->id){
                if(isset($data['tids'])){
                    $tag_data = [
                        'aid' => $id,
                        'tids'=>$data['tids'],
                    ];
                    $this->blog_tag->addData($tag_data);
                }
                if(!empty($data['image_path'])){
                    $pic_data = [
                        'aid' => $id,
                        'image_path'=> $data['image_path']
                    ];
                    //添加图片路径
                    $this->blog_pic->addData($pic_data);
                }
                // 获取未删除和展示的文章
                $sitemap_map=array(
                    'is_show'=>1,
                );
                $list=$this::field('id,update_time')
                    ->where($sitemap_map)
                    ->order('create_time desc')
                    ->select();
                // 生成sitemap文件
                $sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<urlset>\r\n";
                foreach($list as $k=>$v){
                    $sitemap .= "    <url>\r\n"."        <loc>".url('Home/Index/article',array('id'=>$v['id']),'',true)."</loc>\r\n"."        <lastmod>".$v['create_time']."</lastmod>\r\n        <changefreq>weekly</changefreq>\r\n        <priority>0.8</priority>\r\n    </url>\r\n";
                }
                $sitemap .= '</urlset>';
                file_put_contents('./sitemap.xml',$sitemap);
                return 100012;
            }else{
                return 420001;
            }
        }else{
            return 420002;
        }

    }




}