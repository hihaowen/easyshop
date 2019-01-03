<?php

/**
 * 数组操作类
 *
 * Class ArrayPick
 *
 * @author haowenzhi <haowenzhi@cmcm.com>
 */
class ArrayPick implements \ArrayAccess
{
    /**
     * @var array
     */
    private $dataSet;

    /**
     * ArrayObject constructor.
     *
     * @param array $dataSet
     */
    public function __construct(array $dataSet)
    {
        $this->dataSet = $dataSet;
    }

    /**
     * 根据"."区分多维数组获取数组中指定Key的值
     *
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        $segments = explode('.', $key);

        $tmp = $this->dataSet;

        $find = true;

        $value = $default;

        foreach ($segments as $segment) {
            if (isset($tmp[$segment])) {
                $tmp = $tmp[$segment];
                $value = $tmp;
            } else {
                $find = false;
            }
        }

        return $find ? $value : $default;
    }

    /**
     * 获取传入的数组
     *
     * @return array
     */
    public function getDataSet()
    {
        return $this->dataSet;
    }

    /**
     * 根据 Key 查看值是否存在
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->dataSet[$offset]);
    }

    /**
     * 获取指定 Key 的值
     *
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->dataSet[$offset]) ? $this->dataSet[$offset] : null;
    }

    /**
     * 设置指定 Key 的值
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->dataSet[$offset] = $value;
    }

    /**
     * 删除指定 Key 和值
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->dataSet[$offset]);
        }
    }

}
