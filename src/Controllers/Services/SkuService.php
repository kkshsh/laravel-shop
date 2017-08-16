<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/3/24
 * Time: 上午11:03
 */

namespace  SimpleShop\Commodity\Controllers\Services;


use App\Exceptions\ResourcesNotFoundException;
use App\Services\User\Store;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use SimpleShop\Commodity\Commodity;
use SimpleShop\Commodity\Goods\Criteria\GoodsLine;
use SimpleShop\Commodity\Goods\Criteria\OrderPrice;
use SimpleShop\Commodity\Goods\Criteria\ProductGetNatureAndManMade;
use SimpleShop\Commodity\Goods\Criteria\ProductGoods;
use SimpleShop\Commodity\Goods\Criteria\ProductListSearch;
use SimpleShop\Commodity\Goods\Criteria\ProductWith;
use SimpleShop\Commodity\Goods\Criteria\StoreId;
use Cache;

class SkuService extends AbstractCommodity
{
    /**
     * @param Store $store
     * @param array $search
     * @param int $limit
     * @param null $page
     * @return LengthAwarePaginator
     */
    public function index(Store $store, array $search = [], int $limit = 20, $page = null)
    {
        // 获取自营的店铺ids
        $storeList = $store->getSelfStore();
        $storeSelfIds = $store->getStoreIds($storeList);

        // 只查询人造板材和天然原木
        $data = Commodity::search()->sku()
            ->pushCriteria(new GoodsLine('shop_goods_product'))
            ->pushCriteria(new ProductGoods())
            ->pushCriteria(new ProductWith())
            ->pushCriteria(new StoreId($storeSelfIds, 'shop_goods'))
            ->pushCriteria(new ProductGetNatureAndManMade())
            ->pushCriteria(new ProductListSearch($search))
            ->pushCriteria(new OrderPrice($search, 'shop_goods_product'))
            ->paginate($limit, ['*'], $page);
        $data = Commodity::sku()->getListAttrValue($data);
        $data = Commodity::sku()->getListSpecValue($data);
        return $data;
    }

    /**
     * 商品sku的详情
     *
     * @param int $id
     * @param Store $store
     * @return mixed
     */
    public function detail(int $id, Store $store)
    {
        $product = Commodity::sku()->find($id);

        if (! $product) {
            throw new ResourcesNotFoundException('该商品已经被删除');
        }
        $product = $product->toArray();
        //获取商品信息
        if (! config('commodity.cache.time')) {
            $detail = Cache::rememberForever($this->getKey($product['goods_id']), function () use ($product) {
                return Commodity::search()->findGoods($product['goods_id']);
            });
        } else {
            $detail = Cache::remember($this->getKey($product['goods_id']), config('commodity.cache.time'), function () use ($product) {
                return Commodity::search()->findGoods($product['goods_id']);
            });
        }

        // 处理spec,获取不同的sku组合
        $specOut = static::getSpecToSku()->handler($detail['spec']);
        $detail['sku'] = json_encode($this->getSkuArray($product['goods_id'], $specOut));
        $detail['spec'] = $this->groupBySpec($detail['spec']);
        //查询出符合条件的sku并赋值
        $detail['choose_sku'] = $product;
        $selfStores = $store->getSelfStore();
        $option['store_id'] = $store->getStoreIds($selfStores);
        // 处理推荐商品
        $detail['recommend'] = static::getRecommend()->setData($product['goods_id'], $option)->getData();

        return $detail;
    }
}