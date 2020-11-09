<?php
use app\ExceptionHandle;
use app\Request;

// 容器Provider定义文件
return [
    'think\Paginator'    =>    \app\blog\extend\BlogPageStyle::class,
];
