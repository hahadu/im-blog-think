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
            $data['content']=preg_ueditor_image_path($data['content']);
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
            $data['current']['content']=preg_ueditor_image_path($data['current']['content']);
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
            $v['content']=preg_ueditor_image_path($v['content']);
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
        if($this->create($data)){
            $id=$data['id'];
            $this->where(array('id'=>$id))->save();
            $image_path=get_ueditor_image_path($data['content']);
            $this->blog_tag->deleteData($id);
            if(isset($data['tids'])){
                $this->blog_tag->addData($id,$data['tids']);
            }
            // 删除图片路径
            $this->blog_pic->deleteData($id);
            if(!empty($image_path)){
/*
                //设置水印
                if(config('image.water')!=0){
                    foreach ($image_path as $k => $v) {
                        add_water('.'.$v);
                    }
                }
*/
                // 添加新图片路径
                $this->blog_pic->addData($id,$image_path);
            }
            return true;
        }else{
            return false;
        }
    }





}