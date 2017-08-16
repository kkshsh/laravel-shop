<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/11
 * Time: 下午2:14
 */

namespace  LWJ\Commodity\Controllers\Services\Recommend;


class Factory
{
    /**
     * 实例化对应的类
     *
     * @param string|null $handle
     * @return RandomGoods|RelationGoods
     */
    public static function make(string $handle = null)
    {
        switch ($handle) {
            case 'relation' :
                return new RelationGoods();
                break;
            case 'random' :
                return new RandomGoods();
                break;
            default :
                return new RelationGoods();
        }
    }
}