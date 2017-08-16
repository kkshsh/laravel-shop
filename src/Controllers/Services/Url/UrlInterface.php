<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/18
 * Time: 下午6:02
 */

namespace  Commodity\Controllers\Services\Url;


interface UrlInterface
{
    /**
     * @return array
     */
    public function handle();

    /**
     * @param array $data
     * @param array $other
     * @return $this
     */
    public function setData(array $data, array $other);
}