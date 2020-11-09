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
 *  | Date: 2020/11/6 下午9:51
 *  +----------------------------------------------------------------------
 *  | Description:   water
 *  +----------------------------------------------------------------------
 **/
return [
    'add_water_type' => 1, //添加水印 0不添加水印，1添加文字水印，2添加图片水印
    'add_water_config' =>[
        'save_path' => 'upload/images/'.date("Ymd").'/water/',
        'water_mark_text' => '@im_blog',
        'water_x' => 'right',
        'water_y' => 'down',
        'text_style' =>[
            'font_size' => 20, //字体大小
            'fill_color' => '#ffffffff',//字体颜色，支持标准色值，
            'under_color' => '#ffffff00',//背景颜色，支持标准色值
            'fill_opacity' => '0.5', //浮点数0-1，透明度，这里设置透明度会覆盖fill_color中的透明度
            'stroke_width' =>0.1, //描边
        ],
        'water_mark_image'=> 'logo.png',
        'image_option'=>[
            'format' => 'jpg', //保存文件格式后缀
            'opacity' => 5,//设置图像透明度,值越大可见度越低，目前仅支持带alpha通道的图片
        ],
    ],

];

