<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/9/30
 * Time: 11:30
 */

namespace SimpleShop\Commodity\Repositories\CriteriaProduct;


use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class ProductId extends Criteria
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
        if (isset($this->search['product_id'])) {
            if (is_array($this->search['product_id'])) {
                $model = $model->whereIn('shop_goods_product.id', $this->search['product_id']);
            } else {
                $model = $model->where('shop_goods_product.id', $this->search['product_id']);
            }
        }

        if (isset($this->search['sku_id'])) {
            $model = $model->where('shop_goods_product.id', $this->search['sku_id']);
        }

        return $model;
    }

}