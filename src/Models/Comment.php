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
 *  | Date: 2020/11/4 下午5:45
 *  +----------------------------------------------------------------------
 *  | Description:   Comment
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\Models;
use Hahadu\Helper\DateHelper;
use Hahadu\Helper\StringHelper;
use Hahadu\ThinkBaseModel\BaseModel;
use app\user\model\Users;
use think\facade\Db;
use think\model\concern\SoftDelete;

class Comment extends BaseModel
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = NULL;

    private $child=[];
    protected $users;
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->users = new Users();

    }

    /**
     * 添加数据
     * @param integer $type 1：文章评论
     */
    public function addData($type){
        $data=request()->post();
        $ouid=get_uid();
        $username=get_user('username');
        $is_admin=$this->users->getFieldById($ouid,'username');
        $data['content']=htmlspecialchars_decode($data['content']);
        $data['content']=preg_replace('/on.+\".+\"/i', '', $data['content']);
        // 删除除img外的其他标签
        $comment_content=trim(strip_tags($data['content'],'<img>'));
        $content=htmlspecialchars($comment_content);
        if (empty($content)) {
            return 420003;
        }
        $time = time();
        $comment=array(
            'ouid'=>$ouid,
            'type'=>$type,
            'aid'=>$data['aid'],
            'pid'=>$data['pid'],
            'content'=>$content,
            'create_time'=>$time,
            'status'=>1
        );
        // 添加数据 返回新增的评论id
        $cmtid=parent::addData($comment);
        if($cmtid){
            $result = 1;
        }else{
            $result = $cmtid;
        }

        // 给站长发送通知邮件
        $smtp = config('smtp');
        $url = url('/blog/index/detail',array('id'=>5),true,true);
        if(config('comment.COMMENT_SEND_EMAIL') && $is_admin==0){
            $address=config('comment.EMAIL_RECEIVE_ADMIN'); //收件人
            if(!empty($address)){
                $title=Db::name('blog')->getFieldByid($data['aid'],'title');
                $date=date('Y年m月d日 H:i:s',$time);
                $send_admin_content_id = config('comment.COMMENT_SEND_ADMIN_ID');
                $send_admin_content_data = Db::name('send_msg_content')->find($send_admin_content_id);

                $content = sprintf($send_admin_content_data['content'],$username,$date,$url,$title,$comment_content);
                send_email($address,$send_admin_content_data['title'].':'.StringHelper::re_substr($comment_content,0,5),$content,$smtp);
            }
        }
        // 给用户发送邮件通知
        if (config('comment.COMMENT_SEND_EMAIL') && $data['pid']!=0) {
            $parent_data=Db::name('users')->field('username,email')->find($ouid);
            $parent_address=$parent_data['email'];
            if (!empty($parent_address)) {
                $parent_name=$parent_data['nickname'];
                $title=Db::name('blog')->getFieldByid($data['aid'],'title');
                $date=date('Y-m-d H:i:s',$time);
                $parent_content_data=Db::name('send_msg_content')->find(config('comment.COMMENT_SEND_USER_ID'));
                $parent_content = sprintf($parent_content_data['content'],$parent_name,$username,$date,$url,$title,$comment_content);

                send_email($parent_address,$parent_content_data['title'].':'.StringHelper::re_substr($comment_content,0,5),$parent_content,$smtp);
            }

        }
        return $result;
    }

    /**
     * 获取分页数据供后台使用
     * @param  int   是否删除
     * @return array 评论数据
     */
    public function getDataByState(){
        $count=$this::alias('c')
            ->join('blog a','a.aid=c.aid')
            ->join('users ou','ou.id=c.ouid')
//            ->where(array('c.delete_time'=>$is_delete))
            ->count();
        $page=new \Org\Bjy\Page($count,15);
        $list=$this::field('c.*,a.title,ou.nickname')
            ->alias('c')
            ->join('blog a','a.aid=c.aid')
            ->join('users ou','ou.id=c.ouid')
//            ->where(array('c.delete_time'=>$is_delete))
            ->limit($page->firstRow.','.$page->listRows)
            ->order('create_time','desc')
            ->select();
        $data=array(
            'data'=>$list,
            'page'=>$page->show()
        );

        return $data;
    }

    /**
     * 传递文章id获取树状结构的评论
     * @param  int $aid 文章id
     * @return array    树状结构数组
     */
    public function getChildData($aid){
        // 组合where条件
        $status= config('comment.comment_review') ? array('c.status'=>1) : array();
        $other=array(
            'c.aid'=>$aid,
            'c.pid'=>0,
            'c.delete_time'=>null
        );
        $where=array_merge($status,$other);
        // 关联第三方用户表获取一级评论
        $data=$this::alias('c')
            ->field('c.*,ou.username,ou.avatar')
            ->join('users ou','c.ouid=ou.id')
            ->where($where)
            ->order('create_time','desc')
            ->select();
       // $data = $data->toArray();
        foreach ($data as $k => $v) {
            $data[$k]['content']=htmlspecialchars_decode($v['content']);
            // 获取二级评论
            $this->child=[];
            $this->getTree($v);
            $child=$this->child;
            if(!empty($child)){
                // 按评论时间asc排序
                uasort($child,'comment_sort');
                foreach ($child as $m => $n) {
                    // 获取被评论人id
                    $reply_user_id=$this::getFieldByCmtid($n['pid'],'ouid');
                    // 获取被评论人昵称
                    $child[$m]['reply_name']=Db::name('users')->getFieldById($reply_user_id,'username');
                }
            }
            $data[$k]['child']=$child;
        }
        return $data;
    }
    // 递归获取树状结构
    public function getTree($data){
        $child=$this
            ->field('c.*,ou.username,ou.avatar')
            ->alias('c')
            ->join('users ou','c.ouid=ou.id')
            ->where(array('pid'=>$data['cmtid']))
            ->select();
        if(!empty($child)){
            foreach ($child as $k => $v) {
                $v['content']=htmlspecialchars_decode($v['content']);
                $this->child[]=$v;
                $this->getTree($v);
            }
        }

    }

    /**
     * 获取最新的评论
     */
    public function getNewComment(){
        // 获取后台管理员
        $uids=Db::name('users')
            ->where('username','admin')
            ->value('id');
        // 如果没有设置管理员；显示全部评论
        if (empty($uids)) {
            $map=array(
                'c.delete_time'=>null
            );
        }else{
            // 设置了管理员；则不显示管理员的评论
            $map=array(
                'ou.id'=>array('notin',$uids),
                'c.delete_time'=>null
            );
        }
        $data=$this
            ->alias('c')
            ->field('c.content,c.create_time,a.title,a.id,ou.username,ou.avatar')
            ->join('blog a','c.aid=a.id')
            ->join('users ou','c.ouid=ou.id')
            ->where($map)
            ->order('c.create_time desc')
            ->limit(10)
            ->select();
        foreach ($data as $k => $v) {
         //   $data[$k]['create_time']=DateHelper::word_time($v['create_time']);
            // 截取文章标题
            $data[$k]['title']=StringHelper::re_substr($v['title'],0,20);
            // 处理有表情时直接截取会把img表情截断的问题
            $content=strip_tags(htmlspecialchars_decode($v['content']));
            if (mb_strlen($content)>10) {
                $data[$k]['content']=StringHelper::re_substr($content,0,40);
            }else{
                $data[$k]['content']=htmlspecialchars_decode($v['content']);
            }
            $data[$k]['url'] = url('/blog/index/detail',array('id'=>$v['id']));
        }
        return $data;
    }


}