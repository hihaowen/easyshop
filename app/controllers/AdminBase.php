<?php

use Yaf\Application;
use Yaf\Controller_Abstract;

/**
 * Class AdminBaseController
 *
 * @author haowenzhi <haowenzhi@cmcm.com>
 */
class AdminBaseController extends Controller_Abstract
{
    /**
     * 初始化
     */
    public function init()
    {
        Yaf\Dispatcher::getInstance()->disableView();

        if (! $this->getRequest()->isCli()) {
			// 允许跨域
			$this->accessCrossDomain();
        }
    }

    /**
     * 允许跨域请求
     */
    private function accessCrossDomain()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Auth-Token");
            header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');
            exit;
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 43200'); // 12小时
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
    }

    /**
     * 成功的数据返回
     *
     * @param $data
     * @param string $message
     * @return bool
     */
    protected function jsonData($data, $message = '')
    {
        return $this->jsonView(
            array(
                'errno' => 0,
                'error' => $message,
                'data' => $data,
            )
        );
    }

    /**
     * 带有错误的状态返回
     *
     * @param $errno
     * @param string $message
     * @return bool
     */
    protected function jsonStatus($errno, $message = '')
    {
        return $this->jsonView(
            array(
                'errno' => intval($errno),
                'error' => $message,
                'data' => new \stdClass(),
            )
        );
    }

    /**
     * 以Json格式化输出
     *
     * @param array $dataSet
     * @return bool
     */
    protected function jsonView(array $dataSet)
    {
        $this->getResponse()->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->getResponse()->setBody(json_encode($dataSet));

        return true;
    }
}
