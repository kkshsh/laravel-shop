<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace SimpleShop\Commodity\Repositories\Criteria;
use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class ProductIds extends Criteria {

    private $id;

    public function __construct(array $id)
    {
        $this->id = $id;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $tModel = $model->getModel()->getTable();
        $query = $model->whereIn("$tModel.id", $this->id);
        return $query;
    }

}