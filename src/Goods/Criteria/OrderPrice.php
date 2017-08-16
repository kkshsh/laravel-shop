<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/19
 * Time: 下午5:22
 */

namespace Commodity\Goods\Criteria;


use Commodity\Contracts\RepositoryInterface as Repository;
use Commodity\Criteria\Criteria;

class OrderPrice extends Criteria
{
    private $search = [];

    private $table;

    public function __construct(array $search = [], $table = 'shop_goods')
    {
        $this->table = $table;
        $this->search = $search;
    }

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        if (! empty($this->search['order_price'])) {
            $model = $model->orderBy($this->table . '.price', $this->search['order_price']);
        }

        return $model;
    }
}