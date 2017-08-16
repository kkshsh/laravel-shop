<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/22
 * Time: 上午10:27
 */

namespace SimpleShop\Commodity\Goods\Criteria;


use Illuminate\Database\Eloquent\Builder;
use SimpleShop\Commodity\Contracts\RepositoryInterface as Repository;
use SimpleShop\Commodity\Criteria\Criteria;

class ProductWith extends Criteria
{
    /**
     * @param Builder $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model
            ->with([
                'attrChoose.attr' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->with([
                'attrChoose.attrValue' => function ($query) {
                    $query->select('id', 'name', 'attr_id');
                }
            ]);
    }
}