<?php


namespace Hahadu\ImBlogThink\Models;


use Hahadu\Helper\HttpHelper;
use Hahadu\ImBlogThink\Models\Category;
use Hahadu\ThinkBaseModel\BaseModel;
use QL\QueryList;

class CollectUrl extends BaseModel
{
    protected $ql;
    protected $category;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->ql = new QueryList();
        $this->category = new Category();

    }

    public function save_page_url($data){
        $check_page_url = $this->where(['page_url' => $data['page_url']])->findOrEmpty();
        if ($check_page_url->isEmpty()) {
            $url_id = $this->addData($data);
        } else {
            $url_id = $check_page_url->id;
        }
        return $url_id;
    }

    public function read_url_list($type){
        return $this->where('type',$type)->select();
    }


    /****
     * ��ȡ����url�б�
     * @param string $pagUrl ҳ������
     * @param string $itemAttr ��ǩ����
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
     */
    public function get_item_href($html, $itemAttr)
    {
        return $this->ql->html($html)->find($itemAttr)->attrs('href');
    }

    /******
     * �ɼ�Ŀ��˵�����head��Ϣ
     * @param string $url ҳ������
     * @param string $navAttr һ���˵���ǩ����
     * @param string $childAttr �����˵���ǩ����
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
     * ��װ�˵���Ϣ
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
     * ��װҳ��ͷ����Ϣ
     * @param string $url ҳ������
     * @return \stdClass
     */
    public function get_metas($url)
    {
        $head = new \stdClass();
        $ql = $this->ql;
        $html = $ql->get($url)->getHtml();
        $head_html = QueryList::html($html)->find('head')->html();

        $head->title = QueryList::html($head_html)->find('title')->html();
        $head->keywords = QueryList::html($head_html)->find("meta[name='keywords']")->attr('content');
        $head->description = QueryList::html($head_html)->find("meta[name='description']")->attr('content');

        return $head;
    }

    /*****
     * 获取文章链接
     * @param $tags
     * @return array
     */
    public function get_item_url($tags){
        $nav_list = $this->collect_url->read_url_list(1);
        //$tags = '.home-post-list>.postlist-item>.post-img>a';
        $ids = [];
        foreach ($nav_list as $key=>$page) {
            $parent_html = HttpHelper::get($page->page_url);
            $item_list = $this->collect_url->get_item_href($parent_html, $tags)->all();
            $cid = $page->cid;
            //写入数据库
            foreach ($item_list as $k => $item) {
                $data = [
                    'cid'=>$page->cid,
                    'page_url'=> $item,
                    'type'=>2,
                ];
                $url_id = $this->collect_url->save_page_url($data);
                $ids[$key][$k]=$url_id;
            }

        }
        return $ids;
    }



}