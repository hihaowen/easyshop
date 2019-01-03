<?php

/**
 * test Controller
 *
 * Class ClassesController
 *
 * @author haowenzhi <haowenzhi@cmcm.com>
 */
class TestController extends AdminBaseController
{
    /**
     * 列表 @todo
     */
    public function indexAction()
    {
        try {
            $pageInfo = new PageInfo($this->getRequest()->getRequest('pn'), $this->getRequest()->getRequest('rn'));

            $list = [1, 2, 3];

            $total = count($list);

            return $this->jsonData(
                [
                    'list' => $list,
                    'pageInfo' => $pageInfo->getPageInfo($total),
                ]
            );
        } catch (\Exception $e) {
            return $this->jsonStatus($e->getCode(), $e->getMessage());
        }
    }
}
