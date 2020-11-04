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
 *  | Date: 2020/10/25 下午8:23
 *  +----------------------------------------------------------------------
 *  | Description:   Blog时间处理函数
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImBlogThink\extend;
use Hahadu\Helper\DateHelper;

class DateTimeFormat
{
    protected $time;
    public function __construct($time){
        $this->time = $time;
    }
    public function date_format(){
      return DateHelper::format_time($this->time);
    }
    public function __toString()
    {
        return $this->date_format();
    }

}