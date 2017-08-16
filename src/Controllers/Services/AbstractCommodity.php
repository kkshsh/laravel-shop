<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/3/16
 * Time: 下午4:28
 */

namespace  Commodity\Controllers\Services;

use App;

use Commodity\Controllers\Services\Recommend\RelationGoods;
use Commodity\Controllers\Services\Spec\DescartesSpec;
use Commodity\Commodity;
use Commodity\Controllers\Services\Spec\MinimumPriceChoose;
use Commodity\Models\ShopGoodsProductModel;

abstract class AbstractCommodity
{
    /**
     * @return Spec\SpecToSkuInterface
     */
    public static function getSpecToSku()
    {
        return app()->make(DescartesSpec::class);
    }

    /**
     * @return GoodsRecommendInterface|mixed
     */
    public static function getRecommend()
    {
        return App::make(RelationGoods::class);
    }

    /**
     * @return ChooseSkuInterface|mixed
     */
    public function getChooseSku()
    {
        return App::make(MinimumPriceChoose::class);
    }

    /**
     * 从数据库查询对应的sku
     *
     * @param int $id
     * @param array $input
     * @return array
     */
    protected function getSkuArray(int $id, array $input) :array
    {
        $output = [];

        foreach ($input as $item) {
            /** @var ShopGoodsProductModel $sku */
            $sku = Commodity::getSKU($id, $item);
            if (is_null($sku)) {
                throw new App\Exceptions\ResourcesNotFoundException('没有找到该商品对应的sku,请查看其他商品');
            }

            $output[] = $sku->toArray();
        }

        return $output;
    }

    /**
     * 为spec分类
     *
     * @param array $input
     * @return array
     */
    protected function groupBySpec(array $input) :array
    {
        $temp = [];
        foreach ($input as $item) {
            $temp[$item['spec_name']][] = $item;
        }

        return $temp;
    }

    /**
     * @param int $id
     * @return string
     */
    public function getKey(int $id)
    {
        return sha1(config('commodity.cache.key') . $id);
    }
}