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
 *  | Date: 2020/11/4 下午5:56
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/

if(!function_exists('comment_sort')){
// 评论系统自定义排序
    function comment_sort($a,$b){
        $prev = isset($a['date']) ? $a['date'] : 0;
        $next = isset($b['date']) ? $b['date'] : 0;
        if($prev == $next)return 0;
        return ($prev<$next) ? -1 : 1;
    }
}
/****
 * @param $code
 * @param string|null $jumpUrl
 * @param int|null $waitSecond
 */
if(!function_exists('jump_page')){
    function jump_page($code,$jumpUrl = null,$waitSecond = null){
        return \Hahadu\ThinkJumpPage\JumpPage::jumpPage($code,$jumpUrl,$waitSecond);
    }
}
