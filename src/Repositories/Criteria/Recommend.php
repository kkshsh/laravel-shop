<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/12/19
 * Time: 10:56
 */

namespace SimpleShop\Commodity\Repositories\Criteria;


use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class Recommend extends Criteria
{
    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $model = $model->where('shop_goods.status', 1)->orderBy('shop_goods.recommend', 'desc')
            ->orderBy('shop_goods.hot', 'desc');

        return $model;
    }
}