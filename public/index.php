<?php
/**
 * 单入口文件
 */
//1,加载composer的autoload.php文件
//2,实现自动加载相应文件中相应的命名空间下的类
require_once "../vendor/autoload.php";


//1，调用应用run方法
//2，初次加载时会报错需要在composer.json中写入相应文件的路径和相应命名空间的路径
\houdunwang\core\Boot::run();








