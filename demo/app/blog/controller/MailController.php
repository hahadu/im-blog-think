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
 *  | Date: 2020/10/27 上午12:28
 *  +----------------------------------------------------------------------
 *  | Description:   邮件处理
 *  +----------------------------------------------------------------------
 **/

namespace app\blog\controller;
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
use Hahadu\ImBlogThink\Controller\BaseBlogController;
use Hahadu\Helper\ImageHelper;
use Hahadu\Helper\StringHelper;
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
use think\App;
use think\facade\Db;
use function Couchbase\fastlzCompress;


class MailController
{
    public function index(){

/*        $width =  200;
        $height = 200;
        $border = 2;

        $img = new \Imagick();
        $img->newImage( $width, $height, new \ImagickPixel( 'transparent' ) );

        $draw = new \ImagickDraw();
        $draw->setStrokeColor( new \ImagickPixel( '#00F' ) );
        $draw->setStrokeWidth( 2 );
        $draw->setFillColor( new \ImagickPixel( 'transparent' ) );

        // will fail in an obscure manner if the input data is invalid
        $points = array
        (
            array( 'x' => 0, 'y' => 200 ),
            array( 'x' => 0, 'y' => 0 ),
            array( 'x' => 200, 'y' => 200 ),
            array( 'x' => 200, 'y' => 0 )
        );

        $draw->bezier($points);

        $img->drawImage( $draw );
        $img->setImageFormat( "png" );
        $img->writeImage('sgsgsgsgs.png');

        header( "Content-Type: image/png" );
        echo $img;
        die;*/
/*        $strokeColor='#00f'; //画笔颜色
        $fillColor='#FFFFFF00';
        $backgroundColor='#0F0'; //背景颜色
        $draw = new \ImagickDraw();

        $strokeColor = new \ImagickPixel($strokeColor);
        $fillColor = new \ImagickPixel($fillColor);
      //  $draw->setStrokeWidth(50);

        $draw->setStrokeOpacity(1);
        $draw->setStrokeColor($strokeColor);
        $draw->setFillColor($fillColor);

        $draw->setStrokeWidth(15); //设置画笔粗细

        $smoothPointsSet = [
            [
                ['x' => 10.0 * 5, 'y' => 10.0 * 5],
                ['x' => 30.0 * 5, 'y' => 90.0 * 5],
                ['x' => 25.0 * 5, 'y' => 10.0 * 5],
                ['x' => 50.0 * 5, 'y' => 50.0 * 5],
            ],
            [
                ['x' => 50.0 * 5, 'y' => 50.0 * 5],
                ['x' => 75.0 * 5, 'y' => 90.0 * 5],
                ['x' => 70.0 * 5, 'y' => 10.0 * 5],
                ['x' => 90.0 * 5, 'y' => 40.0 * 5],
            ],
        ];

        foreach ($smoothPointsSet as $points) {
            $draw->bezier($points);
        }

        $disjointPoints = [
            [
                ['x' => 10 * 5, 'y' => 10 * 5],
                ['x' => 30 * 5, 'y' => 90 * 5],
                ['x' => 25 * 5, 'y' => 10 * 5],
                ['x' => 50 * 5, 'y' => 50 * 5],
            ],
            [
                ['x' => 50 * 5, 'y' => 50 * 5],
                ['x' => 80 * 5, 'y' => 50 * 5],
                ['x' => 70 * 5, 'y' => 10 * 5],
                ['x' => 90 * 5, 'y' => 40 * 5],
            ]
        ];
        $draw->translate(0, 200);

        foreach ($disjointPoints as $points) {
            $draw->bezier($points);
        }

        //Create an image object which the draw commands can be rendered into
        $imagick = new \Imagick();
        $imagick->newImage(500, 500, $backgroundColor);
        $imagick->setImageFormat("png");

        //Render the draw commands in the ImagickDraw object
        //into the image.
        $imagick->drawImage($draw);

        //Send the image to the browser
        header("Content-Type: image/png");
        echo $imagick->getImageBlob();
        die;*/


        $image = 'iphonex.jpg';

        $config = new Config();
        Factory::setOptions($config);
     //   echo $this->verify();

     //   dump(session());
        //此处option设置对应值会覆盖$config->TextStyle中的默认值
      //  $img_captcha_url = Factory::text_to_image()->captcha_creat();
        if(request()->isPost()){
            /****
             * 返码说明：
             * 1：成功
             * 420105：验证码错误
             * 420106：验证码过期
             */
           return dump(Factory::text_to_image()->captcha_check(request()->post('code')));
        }

       echo  '<form method="post">
<input name="code" type="text">
<input type="submit"value="提交">
</form>';

        echo "<img src=".url('verify').">";
      //  echo $img_captcha_url;
   //     die;
      //  dump(Factory::base()->get_font_path('SourceHanSansCN-Light.otf'));
      //  $thumb_url = Factory::scale()->thumb($image);
      //  dump($img_captcha_url);
     //   return '<img src="'.$img_captcha_url.'"/>';
/*        $text_mark_url = Factory::text_to_image()->text_create_image($text,$option);
      //  $thumb_url = Factory::scale()->thumb($image);
        dump($text_mark_url);
        return '<img src="'.$text_mark_url.'"/>';*/
      //  echo Factory::image_to_text()->to_text_color($image);

       // echo ImageHelper::test();
      //  cooledump(ImageHelper::test());
       // dump($this->create());
      //  return '<img src="/'.ImageHelper::text_to_icon('咋S','avatar').'"/>';

      //  echo $this->indexs();die;
    }
    public function verify(){
/*        $tt = function($number){
            for($i=0;$i<$number;$i++){
                yield time();
            }
        };*/
        /*
        foreach($tt(100000000000000000000) as $value){
          //  sleep(1);
            echo $value.'<br />';
        }*/
        $config = new Config();
        $config->captcha_config=[
            'expire'   => 1800, // 验证码过期时间（s）
            'useZh'    => true, // 使用中文验证码
            'fontSize' => 30, // 验证码字体大小(px)
            'useCurve' => true, // 是否画混淆曲线
            'useNoise' => true, // 是否添加杂点
            'useImgBg' => true, //是否添加背景图片
            'length'   => 5, // 验证码长度
            'font'     => '', // 验证码字体，不设置随机获取
        ];
        Factory::setOptions($config);

       return Factory::text_to_image()->captcha_creat();
    }

}