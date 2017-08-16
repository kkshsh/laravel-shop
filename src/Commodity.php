<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace LWJ\Commodity;

use LWJ\Commodity\Goods\Info;
use LWJ\Commodity\Goods\Sku;
use LWJ\Commodity\Goods\GoodsSearch;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Commodity
{
    /**
     * @return Info
     */
    public static function info() {
        return app(Info::class);
    }

    /**
     * @return Sku
     */
    public static function sku() {
        return app(Sku::class);
    }

    /**
     * @return GoodsSearch
     */
    public static function search() {
        return app(GoodsSearch::class);
    }

    /**
     * 根据选择的销售属性获取SKU Data
     * @param $goodId
     * @param array $specValue
     */
    public static function getSKU($goodId, array $specValue) {
        return self::sku()->getBySpec($goodId,$specValue);
    }

    /**
     * 扣减库存
     * @param $skuId
     * @param $goodsNum
     */
    public static function deductStock($skuId,$goodsNum) {
        return self::sku()->deductStock($skuId,$goodsNum);
    }
}
