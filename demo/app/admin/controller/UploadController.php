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
    public function index(){
        if(is_post()){
            try {
                $file = request()->file('image');
                dump(json_decode('{"state":"\u6587\u4ef6\u7c7b\u578b\u4e0d\u5141\u8bb8","url":"\/uploadimages\/20201107\/f72e53601ea473b8ba9bae601ecce1d8.png","title":"f72e53601ea473b8ba9bae601ecce1d8.png","original":"images\/20201107\/f72e53601ea473b8ba9bae601ecce1d8.png","type":"png","size":2094}',true));
                dump($file);
                dump($file->getFilename());
                dump($file->getBasename());
                dump($file->getOriginalName()); //获取文件名
                dump($file->getExtension()); //后缀
                dump($file->getType());
                dump($file->extension());
                dump($file->getOriginalExtension());
                dump($file->getSize());


                dump($file->hash());
                $savename = Filesystem::disk('public')->putFile( 'images', $file);
                dump(Filesystem::path($savename)); //文件完整路径 filepath
                dump(Filesystem::getDiskConfig('public'));
             //   Filesystem::
                // Filesystem::
                dump($savename);
             //   dump($_SERVER['DOCUMENT_ROOT']); //入口文件路径

            }catch (Exception $e){
                dump($e);
            }
        }else{

            echo '<form  enctype="multipart/form-data" method="post">
<input type="file" name="image" /> <br> 
<input type="submit" value="上传" /> 
</form> ';
        }

    }
    public function upload(){

    }
    public function base64(){
        if(is_post()){

            $post_data = request()->post('image');
            dump($file_info = base64_file_info($post_data));
            dump($file_info->getFilename());
            $decode = base64_decode($post_data);
            $cache_path = Filesystem::path( '/xxx.png');
            dump(file_put_contents($cache_path,$decode));
            dump($cache_path);
            $files = new file($cache_path);
            dump($files);
            $savename = Filesystem::disk('public')->putFile('images',$files);
            //Filesystem::file();
            dump($files->extension());
            dump($decode);
            dump($savename);
        //    Filesystem::disk('public')->putFile( 'images', $decode);
        }else{
            $files = file_get_contents('dd.jpg');
            $file = fopen('dd.jpg','r');
            $base = fread($file,filesize('dd.jpg'));
            fclose($file);
            dump(base64_encode($files));
            dump($base);
            echo '<form   method="post">
<input type="text" name="image" /> <br> 
<input type="submit" value="上传" /> 
</form> ';

        }
    }

}