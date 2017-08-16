<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace SimpleShop\Commodity\Goods\Criteria;

use SimpleShop\Commodity\Criteria\Criteria;

use SimpleShop\Commodity\Contracts\RepositoryInterface as Repository;


class GoodsLine extends Criteria
{
    /**
     * @var string
     */
    private $table = '';

    /**
     * GoodsLine constructor.
     * @param string $table
     */
    public function __construct($table = 'shop_goods')
    {
        $this->table = $table;
    }

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $column = $this->table . '.status';
        $query = $model->where($column, 1);
        return $query;
    }

}