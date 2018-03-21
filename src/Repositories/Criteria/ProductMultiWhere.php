<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace SimpleShop\Commodity\Repositories\Criteria;

use SimpleShop\Cate\Contracts\Cate;
use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class ProductMultiWhere extends Criteria
{

    private $search = [];

    /**
     * MultiWhere constructor.
     * @param array $search
     *
     *               id  商品ID
     *               name 商品名称（模糊查询）
     *               cate_id 分类ID
     *               store_id 商家ID
     *               store_name 商家名称(模糊查询)
     *
     *
     *
     */
    public function __construct(array $search)
    {
        $this->search = $search;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $tGoods = 'shop_goods';
        $tModel = 'shop_goods_product';

        $tCate = 'shop_cates';
        $model = $model->addSelect("{$tCate}.name as cate_name");
        $model = $model->leftJoin($tCate, "{$tCate}.id", "=", "{$tGoods}.cate_id");

        if (isset($this->search['id']) && $this->search['id']) {
            $model = $model->where("$tModel.id", $this->search['id']);
        }
        if (isset($this->search['goods_id']) && $this->search['goods_id']) {
            $model = $model->where("$tModel.goods_id", $this->search['goods_id']);
        }

        if (isset($this->search['not_ids']) && $this->search['not_ids']) {
            $model = $model->whereNotIn("$tModel.id", $this->search['not_ids']);
        }
        if (isset($this->search['name']) && $this->search['name']) {
            $model = $model->where("$tModel.name", 'like', "%" . trim($this->search['name']) . "%");
        }
        if (isset($this->search['status']) && is_numeric($this->search['status'])) {
            $model = $model->where("$tModel.status", $this->search['status']);
        }
        if (isset($this->search['cate_id']) && $this->search['cate_id']) {
            $model = $model->where("$tGoods.cate_id", $this->search['cate_id']);
        }

        if (!empty($this->search['cateIdAndChild'])) {
            // 获取该cate_id有多少三级的cate_id
            $cateIds = app(Cate::class)->getChildIds($this->search['cateIdAndChild']);
            $model = $model->whereIn("$tGoods.cate_id", $cateIds);
        }

        if (isset($this->search['store_id']) && $this->search['store_id']) {
            $model = $model->where("$tGoods.store_id", $this->search['store_id']);
        }

        if (isset($this->search['store_name']) && $this->search['store_name']) {
            $model = $model->where("$tGoods.store_name", 'like', "%{$this->search['store_name']}%");
        }

        return $model;
    }

}