# im-blog-think
think-php博客/文章管理、发布模块

##### 安装
 
 composer require hahadu/im-blog-think

 ###### 使用
 * 1、导入sql目录中的数据库
 * 2、配置数据库信息
 * 3、创建控制器，
 
 
 前台控制器实例：
 * 控制器必须继承Hahadu\ImBlogThink\Controller\BaseBlogHomeController控制器
 ```php
namespace app\blog\controller;
use Hahadu\ImBlogThink\Controller\BaseBlogHomeController;
use think\App;
use think\facade\View;

class IndexController extends BaseBlogHomeController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $result = $this->get_home_info(); //获取页面常用信息
        View::assign($result);
    }
    //文章首页
    public function index()
    {
        $blogs = $this->blog->getPageData();
        return view('',$blogs);
    }
    //按文章分类查询
    public function category($cid)
    {
        $result =  parent::category($cid);
        if(is_int($result)){
            return jump_page($result);
        }else{
            return view('',$result);
        }

    }
    //文章页
    public function detail($id)
    {
        $result = parent::detail($id);
        if(is_int($result)){
            return jump_page($result);
        }else{
            return view('',$result);
        }

    }
    //按标签查询
    public function tag($tid)
    {
        $result = parent::tag($tid);
        if(is_int($result)){
            return jump_page($result);
        }else{
            return view('',$result);
        }
    }
    //站内搜索
    public function search($search)
    {
        $assign = parent::search($search);
        return view('',$assign);
    }
    //处理提交评论
    public function comment()
    {
        $result =  parent::comment();
        return jump_page($result);
    }
}
```
  #### 后台处理模块
  [hahadu/im-admin-think](https://github.com/hahadu/im-admin-think)
  
  交流qq群 [(点击链接加入群聊【thinkphp6开发交流群】：839695142]https://jq.qq.com/?_wv=1027&k=FxgUKLhJ)
