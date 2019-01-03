<?php
/*
 * @Author: xueyixiang
 */
use Yaf\Bootstrap_Abstract;
use Yaf\Application;
use Yaf\Registry;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
class Bootstrap extends Bootstrap_Abstract
{
	public function _initLoader() {
		\Yaf\Loader::import(APP_PATH . '/vendor/autoload.php');
	}

	public function _initConfig(\Yaf\Dispatcher $dispatcher)
    {
		$this->config = Application::app()->getConfig();
		Registry::set('config', $this->config);
	}

    /**
     * 设置路由
     */
    public function _initRoute()
    {
        // 打开Dispatcher的捕获异常的设置
        if(! ENV_TEST) {
            \Yaf\Dispatcher::getInstance()->catchException(true);
        }
    }

	public function _initDefaultDbAdapter() {
		$capsule = new Manager;
		$capsule->addConnection($this->config->database->toArray());
		$capsule->setEventDispatcher(new Dispatcher(new Container));
		$capsule->setAsGlobal();

        // 在Model中会添加新的连接配置，所以此处要设置全局可访问
        // 而上面setAsGlobal后只可通过Manager全局访问connection、table、schema等方法
        Registry::set('capsule', $capsule);

		//开启Eloquent ORM
		$capsule->bootEloquent();
		class_alias('\Illuminate\Database\Capsule\Manager', 'DB');
	}
}