<?php

define('APP_PATH', realpath(dirname(__FILE__).'/'));

// 环境变量
define('ENV', ini_get('yaf.environ'));
define('ENV_TEST', ENV == 'product' ? false : true );

// 设置时区
date_default_timezone_set('Asia/Shanghai');

$app = new \Yaf\Application(APP_PATH . '/conf/app.ini');
$app->bootstrap()->getDispatcher()->dispatch(new \Yaf\Request\Simple());
