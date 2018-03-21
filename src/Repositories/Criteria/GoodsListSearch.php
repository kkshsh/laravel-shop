<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/3/31
 * Time: 下午2:47
 */

namespace SimpleShop\Commodity\Repositories\Criteria;
use SimpleShop\Cate\Contracts\Cate;
use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class GoodsListSearch extends Criteria
{
    private $search;

    /**
     * GoodsListSearch constructor.
     * @param array $search
     */
    public function __construct(array $search = [])
    {
        $this->search = $search;
    }

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        if (! empty($this->search['cate_id'])) {
            $model = $model->where('shop_goods.cate_id', $this->search['cate_id']);
        }

        if (! empty($this->search['cateIdAndChild'])) {
            // 获取该cate_id有多少三级的cate_id
            $cateIds = app(Cate::class)->getChildren($this->search['cateIdAndChild'],true)->toArray();
            $cateIds = array_column($cateIds, 'id');
            $model = $model->whereIn('shop_goods.cate_id', $cateIds);
        }

        if (! empty($this->search['brand_id'])) {
            $model = $model->where('shop_goods.brand_id', $this->search['brand_id']);
        }

        if (! empty($this->search['status'])) {
            $model = $model->where('shop_goods.status', $this->search['status']);
        }

        if (! empty($this->search['keyword'])) {
            $model = $model->where(function ($query) {
                foreach ($this->search['keyword'] as $search) {
                    $query = $query->where('shop_goods.name', 'like', "%{$search}%");
                }
                return $query;
            });
        }
        if (! empty($this->search['min_price']) && ! empty($this->search['max_price'])) {
            $model = $model->where('shop_goods.price', '>', $this->search['min_price'])
                ->where('shop_goods.price', '<', $this->search['max_price']);
        } elseif (! empty($this->search['min_price']) && empty($this->search['max_price'])) {
            $model = $model->where('shop_goods.price', '>', $this->search['min_price']);
        } elseif (empty($this->search['min_price']) && ! empty($this->search['max_price'])) {
            $model = $model->where('shop_goods.price', '<', $this->search['max_price']);
        }

        return $model;
    }
}