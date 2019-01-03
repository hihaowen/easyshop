<?php

/**
 * 通用分页类
 *
 * Class PageInfo
 *
 * @author haowenzhi <haowenzhi@cmcm.com>
 */
class PageInfo
{
    private $pn;
    private $rn;

    /**
     * PageInfo constructor.
     *
     * @param $inputPN 跳转的页码
     * @param $inputRN 需要显示的数量
     * @param int $maxRN 允许最大显示的数量
     * @param int $minRN 显示的最小数量
     */
    public function __construct($inputPN, $inputRN, $maxRN = 20, $minRN = 1)
    {
        $inputPN = intval($inputPN);
        $inputRN = intval($inputRN);
        $maxRN = abs(intval($maxRN));
        $minRN = abs(intval($minRN));

        if ($inputPN <= 0) {
            $inputPN = 1;
        }

        $this->pn = $inputPN;

        if ($inputRN < $minRN || $inputRN > $maxRN) {
            $inputRN = $maxRN;
        }

        $this->rn = $inputRN;
    }

    /**
     * 获取当前数据 Offset
     *
     * @return int
     */
    public function getOffset()
    {
        return ($this->pn - 1) * $this->rn;
    }

    /**
     * 获取要拉取的数量
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->rn;
    }

    /**
     * 获取页码展示信息
     *
     * @param null $total
     * @return array
     */
    public function getPageInfo($total = null)
    {
        $result = [];

        // 当前第 pn 页
        $result['pn'] = $this->pn;
        // 每页显示 rn 条
        $result['rn'] = $this->rn;
        // 总共 total 条
        $result['total'] = isset($total) ? intval($total) : 0;
        // 总共 total_pn 页
        $result['total_pn'] = ceil($result['total'] / $result['rn']);
        // 上一页码为 prev_pn
        $result['prev_pn'] = $this->pn - 1 > 0 ? $this->pn - 1 : 1;
        // 下一页码为 next_pn
        $result['next_pn'] = $this->pn + 1 > $result['total_pn'] ? $result['total_pn'] : $this->pn + 1;

        return $result;
    }
}
