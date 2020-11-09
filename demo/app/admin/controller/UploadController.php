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
 *  | Date: 2020/11/6 下午5:24
 *  +----------------------------------------------------------------------
 *  | Description:   Upload
 *  +----------------------------------------------------------------------
 **/

namespace app\admin\controller;

use Hahadu\ThinkUeditor\ThinkUeditor;
use think\File;
use think\Exception;
use think\facade\Filesystem;


class UploadController
{
    public function ueditor(){
/*        $ueditor = new ThinkUeditor();
        $editor = $ueditor->ueditor();*/
        echo ueditor();die;
    }

}