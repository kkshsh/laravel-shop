<?php
/**
 * 按照排序字段排序
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace Commodity\Cate\Criteria;
use Commodity\Criteria\Criteria;

use Commodity\Contracts\RepositoryInterface as Repository;


class CateOrderBySort extends Criteria {

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $query = $model->orderBy('sort','DESC');
        return $query;
    }

}