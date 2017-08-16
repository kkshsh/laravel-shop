<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/3/21
 * Time: 下午11:43
 */
namespace  SimpleShop\Commodity\Controllers\Services\Spec;



interface ChooseSkuInterface
{
    /**
     * 选择方法
     *
     * @param array $input
     * @return array
     */
    public function choose(array $input) :array;
}