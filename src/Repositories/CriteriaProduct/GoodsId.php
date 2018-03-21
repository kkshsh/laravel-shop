<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/9/30
 * Time: 10:52
 */

namespace SimpleShop\Commodity\Repositories\CriteriaProduct;


use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class GoodsId extends Criteria
{
    /**
     * @var array
     */
    private $search;

    /**
     * Search constructor.
     *
     * @param array $search
     */
    public function __construct(array $search)
    {
        $this->search = $search;
    }

    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        if (isset($this->search['goods_id'])) {
            $model = $model->where('shop_goods_product.goods_id', $this->search['goods_id']);
        }

        return $model;
    }

}