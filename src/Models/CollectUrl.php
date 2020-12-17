<?php


namespace Hahadu\ImBlogThink\Models;


use Hahadu\Helper\HttpHelper;
use Hahadu\Helper\StringHelper;
use Hahadu\ImBlogThink\Models\Category;
use Hahadu\ThinkBaseModel\BaseModel;
use QL\QueryList;

class CollectUrl extends BaseModel
{
    protected $ql;
    protected $category;
    protected $blog;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->ql = new QueryList();
        $this->category = new Category();
        $this->blog = new Blog();

    }

    /****
     * 保存页面链接
     * @param $data
     * @return int|mixed
     */
    public function save_page_url($data){
        $check_page_url = $this->where(['page_url' => $data['page_url']])->findOrEmpty();
        if ($check_page_url->isEmpty()) {
            $url_id = $this->addData($data);
        } else {
            $url_id = $check_page_url->id;
        }
        return $url_id;
    }

    /****
     * 列出需要采集的文章url
     * @param $type
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function read_url_list($type){
        return $this->where('type',$type)->select();
    }


    /*****
     * 获取文章链接
     * @param string $tags
     * @return array 数组列表
     */
    public function get_item_url($tags){
        $nav_list = $this->read_url_list(1);
        //$tags = '.home-post-list>.postlist-item>.post-img>a';
        $ids = [];
        foreach ($nav_list as $key=>$page) {
            $parent_html = HttpHelper::get($page->page_url);
            $item_list = $this->get_item_href($parent_html, $tags)->all();
            $cid = $page->cid;
            //写入数据库
            foreach ($item_list as $k => $item) {
                $data = [
                    'cid'=>$page->cid,
                    'page_url'=> $item,
                    'type'=>2,
                ];
                $url_id = $this->save_page_url($data);
                $ids[$key][$k]=$url_id;
            }

        }
        return $ids;
    }


    /****
     * 获取文章url列表
     * @param string $pagUrl 页面链接
     * @param string $itemAttr 标签属性
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
     */
    public function get_item_href($html, $itemAttr)
    {
        return $this->ql->html($html)->find($itemAttr)->attrs('href');
    }

    /******
     * 采集目标菜单栏及head信息
     * @param string $url 页面链接
     * @param string $navAttr 一级菜单标签属性
     * @param string $childAttr 二级菜单标签属性
     * @return \Generator
     */
    public function get_nav_info($url, $navAttr, $childAttr)
    {
        $ql = $this->ql;
        $html = $ql->get($url)->getHtml();

        $nav_htmls = $ql->html($html)->find($navAttr)->htmls()->all();
        $nav_info_list = [];
        foreach ($nav_htmls as $key => $item) {
            $name = QueryList::html($item)->find('a:eq(0)')->text();
            $href = QueryList::html($item)->find('a:eq(0)')->attr('href');
            $seo_info = $this->get_metas($href);

            $nav = $this->build_nav_info($name, $href, $seo_info->title, $seo_info->keywords, $seo_info->description);
            $nav_id = $this->save_nav($nav);

            $child_hrefs = $ql->html($item)->find($childAttr)->attrs('*')->all();
            $child_names = QueryList::html($item)->find($childAttr)->texts()->all();
            $child_nav = [];
            foreach ($child_hrefs as $k => $child_href) {
                $_name = (isset($child_names[$k])) ? $child_names[$k] : '';
                $_href = $child_href['href'];
                $_seo_info = $this->get_metas($_href);
                $cnav = $this->build_nav_info($_name, $_href, $_seo_info->title, $_seo_info->keywords, $_seo_info->description);
                if (!empty($cnav)){
                    $child_nav[$k] = $cnav;
                    $cnav['pid']= $nav_id;
                    $cnav_id = $this->save_nav($cnav);

                    $page_data = [
                        'cid' => $cnav_id,
                        'page_url'=> $cnav['href'],
                        'name' => $cnav['cname'],
                        'type'=>1,
                    ];
                    $url_id = $this->save_page_url($page_data);
                    $child_nav[$k]['url_id'] = $url_id;
                }
            }
            $nav_info_list[$key] = compact('nav', 'child_nav');
        }
        yield $nav_info_list;
    }

    /*****
     * 保存菜单
     * @param $nav_data
     * @return int|mixed
     */
    protected function save_nav($nav_data)
    {
        $check_cname = $this->category->where(['cname' => $nav_data['cname']])->findOrEmpty();

        if ($check_cname->isEmpty()) {
            $nav_id = $this->category->addData($nav_data);
        } else {
            $nav_id = $check_cname->cid;
        }
        return $nav_id;
    }


    /*****
     * 封装菜单信息
     * @param $cname
     * @param string $href
     * @param string $title
     * @param string $keywords
     * @param string $description
     * @return array
     */
    protected function build_nav_info($cname, $href = '', $title = '', $keywords = '', $description = '')
    {
        if (null == $title) $title = $cname;
        if (null == $keywords) $keywords = $cname;
        if (null == $description) $description = $cname;
        return compact('cname', 'href', 'title', 'keywords', 'description');
    }

    /*****
     * 封装页面头部信息
     * @param string $url 页面链接
     * @return \stdClass
     */
    public function get_metas($url)
    {
        $head = new \stdClass();
        $ql = $this->ql;
        $html = $ql->get($url)->getHtml();
        $head_html = QueryList::html($html)->find('head')->html();
        $title = QueryList::html($head_html)->find('title')->html();

        $head->title = StringHelper::cut_str($title,'-',0);
        $head->keywords = QueryList::html($head_html)->find("meta[name='keywords']")->attr('content');
        $head->description = QueryList::html($head_html)->find("meta[name='description']")->attr('content');

        return $head;
    }



    /*****
     * 自动采集文章-批量采集
     * @param string $serach_tag 需要采集的标签
     * @param string $remove_tage 需要删除的标签
     * @param int $limit 采集数量
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function collect_items($serach_tag,$remove_tage=null,$limit=5){

        $page_infos = $this->where('type',2)
            ->where('aid',null)
            ->limit($limit)
            ->select();

        foreach ($page_infos as $key=>$page_info) {
            $collect = $this->collect_item($page_info,$serach_tag,$remove_tage);
            return $collect;
        }

    }


    /****
     * 自动采集-采集单个文章
     * @param array|object $page_info 需要采集的对象
     * @param string $serach_tag 需要采集的标签
     * @param string $remove_tage 需要删除的标签
     * @return false|int|mixed|null
     */
    public function collect_item($page_info,$serach_tag,$remove_tage=null){
        if(null===$page_info->aid){
            $page_url = $page_info->page_url;

            $page_html = HttpHelper::get($page_url);

            $item_html = $this->ql->html($page_html)->find($serach_tag);
            if(null!==$remove_tage){
                $item_html->find($remove_tage)->remove();
            }
            $content = $item_html->html();

            $metas = $this->get_metas($page_url);

            //文章写入数据库
            $data = [
                'title' => $metas->title,
                'keywords' =>$metas->keywords,
                'description'=>$metas->description,
                'content'=>$content,
                'author'=>(null !== get_uid())?get_uid():1,
                'cid'=>$page_info->cid,
            ];

            //数据查重
            $checkEmpty = $this->blog->where([
                'title' => $metas->title,
                'keywords'=>$metas->keywords,
                'description'=>$metas->description,
                'content'=>htmlspecialchars($content),
            ])->findOrEmpty();
            if($checkEmpty->isEmpty()){
                $aid = $this->blog->addData($data);
                $aid = $aid['data']['aid'];
            }else{
                $aid = $checkEmpty->id;
            }

            $url_data = [
                'id'=>$page_info->id,
                'aid' => $aid,
                'name'=>$metas->title,
                'collect_time'=>time(),
            ];
            $update = $this::update($url_data);
            if(null!==$update){
                return $aid;
            }else{
                return false;
            }
        }
        return null;
    }



}