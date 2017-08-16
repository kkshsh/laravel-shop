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


class CateLikeName extends Criteria {

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $query = $model->where('name','like',"%{$this->name}%");
        return $query;
    }

}