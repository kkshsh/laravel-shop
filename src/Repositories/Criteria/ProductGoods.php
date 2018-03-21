<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace SimpleShop\Commodity\Repositories\Criteria;
use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class ProductGoods extends Criteria {


    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {

        $tGoods = 'shop_goods';
        $tModel = 'shop_goods_product';
        $model = $model->select(
            "$tModel.*",
            \DB::raw("$tGoods.name as goods_name"),
            \DB::raw("$tGoods.cover_path as goods_cover_path"),
            \DB::raw("$tGoods.store_id as store_id"),
            \DB::raw("$tGoods.store_name as store_name"),
            \DB::raw("$tGoods.brand_id as brand_id"),
            \DB::raw("$tGoods.cate_id as cate_id"),
            \DB::raw("$tGoods.description as description"),
            \DB::raw("$tGoods.unit as unit"),
            \DB::raw("$tGoods.begin_num as begin_num"),
            \DB::raw("$tModel.status as sale_status")
            );
        $model = $model->leftJoin($tGoods,"$tGoods.id",'=',"$tModel.goods_id");
        return $model;
    }

}