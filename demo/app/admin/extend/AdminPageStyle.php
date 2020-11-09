<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/9/21 下午12:01
 *  +----------------------------------------------------------------------
 *  | Description:   cooleAdmin
 *  +----------------------------------------------------------------------
 **/
namespace app\admin\extend;

use think\paginator\driver\Bootstrap;
use think\facade\Request;
use think\facade\Config;

class AdminPageStyle extends Bootstrap{
    /*
    public function url(int $page): string
    {
        if ($page <= 0) {
            $page = 1;
        }

        if (strpos($this->options['path'], '[PAGE]') === false) {
            $parameters = [$this->options['var_page'] => $page];
        } else {
            $parameters = [];
        }

        if (count($this->options['query']) > 0) {
            $parameters = array_merge($this->options['query'], $parameters);
        }
        $depr = Config::get('route.pathinfo_depr'); //路由分隔符
        $url = parse_name(Request::rootUrl()).$depr.parse_name(Request::controller()).$depr.parse_name(Request::action());
        if (!empty($parameters)) {
            $url .= str_replace(array('?','=','&'),$depr,'?' . http_build_query($parameters, '', '&'));
        }
        return $url . $this->buildFragment();
    }
*/
    /**
     * 渲染分页html
     * @return mixed
     */
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<ul class="pager pagination-sm m-0 float-right ellipsis">%s %s</ul>',
                    $this->getPreviousButton(),
                    $this->getNextButton()
                );
            } else {
                return sprintf(
                    '<ul class="pagination pagination-sm m-0 float-right ellipsis">%s %s %s</ul>',
                    $this->getPreviousButton(),
                    $this->getLinks(),
                    $this->getNextButton()
                );
            }
        }
    }

    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  string $page
     * @return string
     */
    protected function getAvailablePageWrapper(string $url, string $page): string
    {
        return '<li class="page-item"><a class="page-link" href="' . htmlentities($url) . '">' . $page . '</a></li>';
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper(string $text): string
    {
        return '<li class="page-item disabled"><span  class="page-link">' . $text . '</span></li>';
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper(string $text): string
    {
        return '<li class="page-item active"><span  class="page-link">' . $text . '</span></li>';
    }

    /**
     * 生成省略号按钮
     *
     * @return string
     */
    protected function getDots(): string
    {
        return $this->getDisabledTextWrapper('...');
    }
}


