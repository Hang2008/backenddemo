<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
//phpinfo();

//echo $_SERVER['HTTP_USER_AGENT'];
//这句有问题
//if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == true) {
//    echo $_SERVER['HTTP_USER_AGENT'];
//} else {
//    echo "jjjjjjjjjjj";
//}
//$processUser = posix_getpwuid(posix_geteuid());
//echo ($processUser['name']);
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
