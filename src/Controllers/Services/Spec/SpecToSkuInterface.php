<?php
/**
 * Created by PhpStorm.
 * User: j5110
 * Date: 2017/3/16
 * Time: 21:27
 */

namespace  SimpleShop\Commodity\Controllers\Services\Spec;


interface SpecToSkuInterface
{
    /**
     * 处理spec的数据，将其转为可以执行Spec查询的目标数据
     *
     * @param array $input
     * @return array
     */
    public function handler(array $input) :array;
}