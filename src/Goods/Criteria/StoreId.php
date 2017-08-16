<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/6
 * Time: 下午12:03
 */

namespace LWJ\Commodity\Goods\Criteria;


use LWJ\Commodity\Contracts\RepositoryInterface as Repository;
use LWJ\Commodity\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;

class StoreId extends Criteria
{
    /**
     * @var array
     */
    private $storeId;

    /**
     * @var string
     */
    private $table;

    /**
     * StoreId constructor.
     * @param array $storeId
     * @param string $table
     */
    public function __construct($storeId, $table = 'shop_goods')
    {
        $this->storeId = $storeId;
        $this->table = $table;
    }

    /**
     * @param Builder $query
     * @param Repository $repository
     * @return Builder
     */
    public function apply($query, Repository $repository)
    {
        $column = $this->table . '.store_id';
        return $query->whereIn($column, $this->storeId);
    }
}