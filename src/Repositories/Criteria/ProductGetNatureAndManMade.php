<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/13
 * Time: 下午8:11
 */

namespace SimpleShop\Commodity\Repositories\Criteria;
use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class ProductGetNatureAndManMade extends Criteria
{
    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $cates = $this->getPid();
        return $model->whereIn('cate_id', $cates->pluck('id')->toArray());
    }

    private function getPid()
    {
        // 获取天然原木和人造板材的cateId
        $cateRootIds = Cate::search()->getByCateDir(config('commodity.cate.default'))->pluck('id')->toArray();

        // 获取分类下面的子分类
        $cate = Cate::search()->pushCriteria(new Cate\Criteria\CateRootId($cateRootIds));

        return $cate->all();
    }
}