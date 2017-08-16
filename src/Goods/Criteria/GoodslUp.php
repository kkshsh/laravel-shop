<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace LWJ\Commodity\Goods\Criteria;
use LWJ\Commodity\Criteria\Criteria;

use LWJ\Commodity\Contracts\RepositoryInterface as Repository;


class GoodslUp extends Criteria {
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $query = $model->where('status', 1);
        return $query;
    }

}