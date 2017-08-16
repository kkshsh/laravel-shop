<?php
/**
 * 模糊搜索分类名称
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace SimpleShop\Commodity\Cate\Criteria;

use SimpleShop\Commodity\Criteria\Criteria;
use SimpleShop\Commodity\Contracts\RepositoryInterface as Repository;


class CatePid extends Criteria
{
    /**
     * @var array
     */
    private $pid;

    public function __construct(array $pid)
    {
        $this->pid = $pid;
    }

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $query = $model->whereIn('pid', $this->pid);
        return $query;
    }

}