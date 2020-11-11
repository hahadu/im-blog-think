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

use Hahadu\ThinkUeditor\ThinkUeditor;

if(!function_exists('comment_sort')){
// 评论系统自定义排序
    function comment_sort($a,$b){
        $prev = isset($a['date']) ? $a['date'] : 0;
        $next = isset($b['date']) ? $b['date'] : 0;
        if($prev == $next)return 0;
        return ($prev<$next) ? -1 : 1;
    }
}

if(!function_exists('preg_editor_image_path')){
    /**
     * 将editor存入数据库的文章中的图片绝对路径转为相对路径
     * @param  string $content 文章内容
     * @return string          转换后的数据
     */
    function preg_editor_image_path($data){
        // 兼容图片路径
        $root_path=rtrim($_SERVER['SCRIPT_NAME'],'/index.php');
        // 正则替换图片
        $data=htmlspecialchars_decode($data);
        $data=preg_replace('/src=\"^\/.*\/upload\/images$/','src="'.$root_path.'/upload/images',$data);
        return $data;
    }
}
