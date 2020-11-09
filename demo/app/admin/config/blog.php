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
 *  | Date: 2020/11/6 上午11:56
 *  +----------------------------------------------------------------------
 *  | Description:   Blog
 *  +----------------------------------------------------------------------
 **/
return [
    'replace_image_attr' => false, //replace title and alt attribute for form img tag, value:false or true
    'default_image_title' => 'im_blog', // default title value in img tag attribute
    'default_image_alt'  => 'im_blog', // default alt value in img tag attribute
    'image_water' => true, //add water
    'image_water_config' =>[
        'savePath' => 'upload/images/'.date("Ymd").'/water/',
        'waterMarkText' => '@im_blog',
        'water_x' => 'right',
        'water_y' => 'down',
        'TextStyle' =>[
            'font_size' => 20, //字体大小
            'fill_color' => '#ffffffff',//字体颜色，支持标准色值，
            'under_color' => '#ffffff00',//背景颜色，支持标准色值
            'fill_opacity' => '0.5', //浮点数0-1，透明度，这里设置透明度会覆盖fill_color中的透明度
        ],
    ],
];


