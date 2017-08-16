<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/3/21
 * Time: 下午11:46
 */

namespace  LWJ\Commodity\Controllers\Services\Spec;


use App\Exceptions\ServiceErrorException;

class MinimumPriceChoose implements ChooseSkuInterface
{
    /**
     * 选择方法
     *
     * @param array $input
     * @return array
     */
    public function choose(array $input): array
    {
        //遍历该数组,将价格装入一个新数组
        $prices = [];
        foreach ($input as $key => $item) {
            $prices[$key] = $item['price'];
        }

        //返回价格最低的键名
        $low = $this->sortPrice($prices);

        //弹出该键名对应的值
        return $input[$low];
    }

    /**
     * 获取价格最低的那个那个SKU
     *
     * @param array $prices
     * @return int
     */
    private function sortPrice(array $prices) :int
    {
        //将数组排序并获取键名
        $bool = asort($prices);
        if (! $bool) {
            throw new ServiceErrorException('排序没有成功');
        }

        $temp = array_keys($prices);
        //弹出第一个值
        return array_shift($temp);
    }
}