<?php

define('APP_PATH', realpath(dirname(__FILE__).'/../'));

// 环境变量
define('ENV', ini_get('yaf.environ'));
define('ENV_TEST', ENV == 'product' ? false : true );

if (ENV_TEST) {
    ini_set('display_errors', 1);
    error_reporting(E_ERROR);
}

// 设置时区
date_default_timezone_set('Asia/Shanghai');

$app = new \Yaf\Application(APP_PATH . '/conf/app.ini');
$app->bootstrap()->run();
