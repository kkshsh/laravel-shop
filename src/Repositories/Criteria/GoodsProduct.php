<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace SimpleShop\Commodity\Repositories\Criteria;
use SimpleShop\Brand\Models\ShopBrand;
use SimpleShop\Commodity\Models\ShopGoodsModel;
use SimpleShop\Commodity\Models\ShopGoodsProductModel;
use SimpleShop\Commons\Models\ShopUnitModel;
use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class GoodsProduct extends Criteria
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $goodsModel = app(ShopGoodsModel::class);
        $tGoods = $goodsModel->getTable();
        $ShopBrandModel = app(ShopBrand::class);
        $ShopUnitModel = app(ShopUnitModel::class);
        $tShopUnit = $ShopUnitModel->getTable();
        $tShopBrand = $ShopBrandModel->getTable();
        $tGoodsProduct = $model->getTable();

        $model = $model->select(
            "$tGoodsProduct.*",
            \DB::raw("$tGoodsProduct.id as sku_id"),
            \DB::raw("$tShopBrand.name as brand_name"),
            \DB::raw("$tShopUnit.name as unit_name"),
            \DB::raw("$tGoodsProduct.sku_name as sku_name")
        );
        $model = $model->leftJoin($tGoods, "{$tGoods}.id", "=", "{$tGoodsProduct}.goods_id");
        $model = $model->leftJoin($tShopBrand, "{$tGoods}.brand_id", "=", "{$tShopBrand}.id");
        $model = $model->leftJoin($tShopUnit, "{$tGoods}.unit_id", "=", "{$tShopUnit}.id");
        return $model;
    }

}