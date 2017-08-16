<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/3/16
 * Time: 下午4:27
 */

namespace  LWJ\Commodity\Controllers\Services;


use LWJ\Commodity\Exceptions\ResourcesNotFoundException;
use LWJ\Commodity\Controllers\Services\SpuListHandler\SpuHandle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use LWJ\Commodity\Commodity;
use LWJ\Commodity\Goods\Criteria\GoodsLine;
use LWJ\Commodity\Goods\Criteria\GoodsListSearch;
use LWJ\Commodity\Goods\Criteria\OrderPrice;
use LWJ\Commodity\Goods\Criteria\StoreId;
use Cache;

class GoodsService extends AbstractCommodity
{
    /**
     * @param array $search
     * @param int $limit
     * @param null $page
     * @return LengthAwarePaginator|Collection
     */
    public function getList(array $search = [], int $limit = 20, $page = null)
    {
        // 获取自营的店铺Id
        // 获取数据
        $list = Commodity::search()->spu()
            ->pushCriteria(new GoodsLine())
            ->pushCriteria(new GoodsListSearch($search))
            ->pushCriteria(new OrderPrice($search))
            ->paginate($limit, ['*'], $page);
        // 处理数据,现在先留着
        $handler = [];
        $list = SpuHandle::make($list, $handler);

        return $list;
    }

    /**
     * 获取商品详情
     * @param int $id
     * @return array
     */
    public function detail(int $id)
    {
        //获取商品的数据

        $detail = Commodity::search()->findGoods($id);

        if (is_null($detail['base'])) {
            throw new ResourcesNotFoundException("商品编号为{$id}的商品已被下架或删除");
        }
        //获取cate
        $detail['base'] = $this->setCate($detail['base']);
        // 处理spec,获取不同的sku组合
        $specOut = static::getSpecToSku()->handler($detail['spec']);
        $detail['sku'] = $this->getSkuArray($id, $specOut);

        $detail['spec'] = $this->groupBySpec($detail['spec']);
        //查询出价格最低的那个SKU并赋值
        $detail['choose_sku'] = static::getChooseSku()->choose($detail['sku']);
        $option['store_id'] = 0;
        // 处理推荐商品
        $detail['recommend'] = static::getRecommend()->setData($id, $option)->getData();
        // 处理照片
        $detail['base'] = $this->setPics($detail['base']);
        return $detail;
    }

    /**
     * @param Model $model
     * @return Model
     */
    protected function setCate(Model $model)
    {
        $cate = $model->cate;

        $model->cate_name = $cate->name;
        $model->tree = $cate->tree;

        return $model;
    }

    /**
     * @param Model $model
     * @return Model
     */
    protected function setPics(Model $model)
    {
        $pics = $model->pics;

        $model->pics = $pics;

        return $model;
    }

    /**
     * 获取店铺商品
     *
     * @param $id
     * @return LengthAwarePaginator|\Illuminate\Contracts\Pagination\Paginator|Collection
     */
    public function getStoreGoods($id)
    {
        // 获取数据
        $list = Commodity::search()->spu()
            ->pushCriteria(new GoodsLine())
            ->pushCriteria(new StoreId([$id]))
            ->pushCriteria(new GoodsListSearch())
            ->paginate(20);
        // 处理数据,现在先留着
        $handler = [];
        $list = SpuHandle::make($list, $handler);

        return $list;
    }
}