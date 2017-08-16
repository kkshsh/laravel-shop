<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/19
 * Time: 下午4:42
 */

namespace LWJ\Commodity\Goods\Criteria;


use App\Exceptions\NotInstanceofException;
use Illuminate\Support\Collection;
use LWJ\Commodity\Cate;
use LWJ\Commodity\Contracts\RepositoryInterface as Repository;
use LWJ\Commodity\Criteria\Criteria;

class ProductListSearch extends Criteria
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
            // 获取该cate_id有多少个三级的cate_id
            $cateIds = Cate::search()->all();
            $cateArray = $this->getLastCateId($this->search['cate_id'], $cateIds);
//            dd($this->search['cate_id'], $cateArray);
            $model = $model->whereIn('shop_goods.cate_id', $cateArray);
        }

        if (! empty($this->search['brand_id'])) {
            $model = $model->where('shop_goods.brand_id', $this->search['brand_id']);
        }
        if (! empty($this->search['status'])) {
            $model = $model->where('shop_goods_product.status', $this->search['status']);
        }

        if (! empty($this->search['keyword'])) {

            if (is_array($this->search['keyword'])) {
                $model = $model->where(function ($query) {
                    foreach ($this->search['keyword'] as $search) {
                        $query = $query->where('shop_goods_product.name', 'like', "%{$search}%");
                    }
                    return $query;
                });
            } elseif (is_string($this->search['keyword'])) {
                $model = $model->where('shop_goods_product.name', 'like', "%{$this->search['keyword']}%");
            } else {
                throw new NotInstanceofException('keyword的类型不合法');
            }
        }

        if (! empty($this->search['min_price']) && ! empty($this->search['max_price'])) {
            $model = $model->where('shop_goods_product.price', '>', $this->search['min_price'])
                ->where('shop_goods_product.price', '<', $this->search['max_price']);
        } elseif (! empty($this->search['min_price']) && empty($this->search['max_price'])) {
            $model = $model->where('shop_goods_product.price', '>', $this->search['min_price']);
        } elseif (empty($this->search['min_price']) && ! empty($this->search['max_price'])) {
            $model = $model->where('shop_goods_product.price', '<', $this->search['max_price']);
        }

        return $model;
    }
}