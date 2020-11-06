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

if(!function_exists('preg_editor_image_path')){
    /**
     * 将ueditor存入数据库的文章中的图片绝对路径转为相对路径
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
if(!function_exists('get_editor_image_path')){
    /**
     * 传递ueditor生成的内容获取其中图片的路径
     * @param  string $str 含有图片链接的字符串
     * @return array       匹配的图片数组
     */
    function get_editor_image_path($str){
        $preg='/\/upload\/images\/\d*\/\d*\.[jpg|jpeg|png|bmp]*/i';
        preg_match_all($preg, $str,$data);
        return current($data);
    }
}

if(!function_exists('add_water')){
    function add_water($image){

        $config = new \Hahadu\ImageFactory\Config\Config();
        $config->savePath = config('water.image_water_config.savePath');
        $config->waterMarkText = config('water.image_water_config.waterMarkText'); //设置水印文字，支持\n换行符
        $config->TextStyle = config('water.image_water_config.TextStyle');
        $x = config('water.image_water_config.water_x');
        $y = config('water.image_water_config.water_y');

        \Hahadu\ImageFactory\Kernel\Factory::setOptions($config);
        return \Hahadu\ImageFactory\Kernel\Factory::text_to_image()->text_water_mark($image,$x,$y);
    }

}
