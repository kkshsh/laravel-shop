<?php
/**
 * 模糊搜索分类名称
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace LWJ\Commodity\Cate\Criteria;
use LWJ\Commodity\Criteria\Criteria;

use LWJ\Commodity\Contracts\RepositoryInterface as Repository;


class BrandCateId extends Criteria {

    private $cateId;

    public function __construct($cateId)
    {
        $this->cateId = $cateId;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $query = $model->where('cate_id',$this->cateId);
        return $query;
    }

}