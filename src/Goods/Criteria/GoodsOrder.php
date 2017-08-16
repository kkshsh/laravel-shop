<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/5/18
 * Time: 上午10:03
 */

namespace SimpleShop\Commodity\Goods\Criteria;


use SimpleShop\Commodity\Contracts\RepositoryInterface as Repository;
use SimpleShop\Commodity\Criteria\Criteria;

class GoodsOrder extends Criteria
{
    /**
     * @var array
     */
    private $order;

    public function __construct(array $order = ['id' => 'desc'])
    {
        $this->order = $order;
    }
    
    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        foreach ($this->order as $key => $item) {
            $model = $model->orderBy($key, $item);
        }

        return $model;
    }
}