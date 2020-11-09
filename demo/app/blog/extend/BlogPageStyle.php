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
namespace app\blog\extend;

use think\paginator\driver\Bootstrap;

class BlogPageStyle extends Bootstrap{
    /**
     * 渲染分页html
     * @return mixed
     */
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<ul class="pagination">%s %s</ul>',
                    $this->getPreviousButton(),
                    $this->getNextButton()
                );
            } else {
                return sprintf(
                    '<ul class="pagination">%s %s %s</ul>',
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
     * @param  string $class 分页样式
     * @return string
     */
    protected function getAvailablePageWrapper(string $url, string $page,$class=''): string
    {
        $class = (null!=$class)?' class="'.$class.'"':'';
        return '<li'.$class.'><a  href="' . htmlentities($url) . '">' . $page . '</a></li>';
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @param string $class 分页样式
     * @return string
     */
    protected function getDisabledTextWrapper(string $text,$class=''): string
    {
        $class = (null!=$class)?' class="'.$class.'"':'';
        return '<li'.$class.'><a href="JavaScript:;">' . $text . '</a></li>';
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper(string $text): string
    {
        return '<li class="current">' . $text . '</li>';
    }
    /**
     * 上一页按钮
     * @param string $text
     * @return string
     */
    protected function getPreviousButton(string $text = "上一页"): string
    {

        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text,'prev');
        }

        $url = $this->url(
            $this->currentPage() - 1
        );

        return $this->getPageLinkWrappers($url, $text,'prev');
    }

    /**
     * 下一页按钮
     * @param string $text
     * @return string
     */
    protected function getNextButton(string $text = '下一页'): string
    {
        if (!$this->hasMore) {
            return $this->getDisabledTextWrapper($text,'next');
        }

        $url = $this->url($this->currentPage() + 1);

        return $this->getPageLinkWrappers($url, $text,'next');
    }
    /**
     * 生成普通页码按钮
     *
     * @param  string $url
     * @param  string    $page
     * @return string
     */

    protected function getPageLinkWrappers(string $url, string $page,$class): string
    {
        if ($this->currentPage() == $page) {
            return $this->getActivePageWrapper($page);
        }

        return $this->getAvailablePageWrapper($url, $page,$class);
    }


}


