<?php
declare (strict_types = 1);

namespace app\blog\controller;
use Hahadu\ImBlogThink\Controller\BaseBlogHomeController;
use think\App;
use think\facade\Db;

class IndexController extends BaseBlogHomeController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function index()
    {
        $blogs = $this->blog->getPageData();
        $assign=array(
            'page'=>$blogs['page'],
            'list'=>$blogs['list'],
            'cid'=>'index'
        );
        return view('',$assign);
    }
    public function category($cid)
    {
        $result =  parent::category($cid);
        if(is_int($result)){
            return jump_page($result);
        }else{
            return view('',$result);
        }

    }

    public function detail($id)
    {
        $result = parent::detail($id);
        if(is_int($result)){
            return jump_page($result);
        }else{
            return view('',$result);
        }

    }
    public function tag($tid)
    {
        $result = parent::tag($tid);
        if(is_int($result)){
            return jump_page($result);
        }else{
            return view('',$result);
        }
    }
    public function search($search)
    {
        $assign = parent::search($search);
        return view('',$assign);
    }
    public function comment()
    {
        $result =  parent::comment();
        return jump_page($result);

    }


}
