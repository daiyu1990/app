<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

set_time_limit(0);
// 应用入口文件
header("Content-type:text/html;charset=utf-8");
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
define('BASE_SIGN','index');
// define('APP_DEBUG',false);
// 关闭目录安全文件
define('BUILD_DIR_SECURE', false);
// 定义应用目录
define('APP_PATH','./Application/');
// // 定义环境
// define('APP_STATUS','dev');
ini_set("memory_limit","1024M");//exit('abc');
ini_set('session.gc_maxlifetime', 3600); //设置时间
ini_get('session.gc_maxlifetime');//得到ini中设定值
ini_set('default_socket_timeout', -1);
// 引入ThinkPHP入口文件
require './ThinkPHP/Library/Vendor/Qiniu/autoload.php';

require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
