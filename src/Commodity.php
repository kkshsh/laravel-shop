<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use SimpleShop\Attr\Attribute;
use SimpleShop\Commodity\Events\GoodsEvent;
use SimpleShop\Commodity\Models\ShopGoodsModel;
use SimpleShop\Commodity\Models\ShopGoodsProductModel;
use SimpleShop\Commodity\Repositories\Criteria\GoodsMultiWhere;
use SimpleShop\Commodity\Repositories\Criteria\GoodsOrder;
use SimpleShop\Commodity\Repositories\Criteria\Recommend;
use SimpleShop\Commodity\Repositories\GoodsAttrRepository;
use SimpleShop\Commodity\Repositories\GoodsImagesRepository;
use SimpleShop\Commodity\Repositories\GoodsProductRepository;
use SimpleShop\Commodity\Repositories\GoodsRepository;
use SimpleShop\Commons\Exceptions\DatabaseException;
use SimpleShop\Spec\Spec as TestSpec;

/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Commodity
{
    protected $goodsRepository;
    protected $goodsProductRepository;
    protected $goodsImagesRepository;
    protected $goodsAttrRepository;
    protected $attribute;

    public function __construct(GoodsRepository $goodsRepository,
                                GoodsProductRepository $goodsProductRepository,
                                GoodsImagesRepository $goodsImagesRepository,
                                GoodsAttrRepository $goodsAttrRepository,
                                Dispatcher $event
                            )
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsImagesRepository = $goodsImagesRepository;
        $this->goodsAttrRepository = $goodsAttrRepository;
        $this->event = $event;
    }

    /**
     * 获取列表
     *
     * @param array $search
     * @param array $orderBy
     * @param int $page
     * @param int $pageSize
     * @return mixed
     */
    public function search(array $search = [], array $orderBy = [], $page = 1, $pageSize = 10)
    {

        return $this->goodsRepository
            ->pushCriteria(new GoodsMultiWhere($search))
            ->pushCriteria(new GoodsOrder($orderBy))
            ->with(['cateInfo','brandInfo','storeInfo'])
            ->paginate($pageSize, ['*'], $page);
    }


    /**
     * @param $data
     *
     * @return
     * @throws \Exception
     * @throws \Throwable
     */

    public function create($data) {
        $priceSection = $this->goodsProductRepository->getPriceSection($data['spec']);
        $data['price'] = $priceSection[0];
        $data['max_price'] = $priceSection[1];

        $goods = \DB::transaction(function() use ($data) {
            $goods = $this->goodsRepository->create($data);
            if (isset($data['imgs'])) {
                $this->goodsImagesRepository->adds($goods->id, $data['imgs']);
            }
            if (isset($data['attr'])) {
                $this->goodsAttrRepository->adds($goods->id, $data['attr']);
            }

            if(isset($data['spec'])) {
                app(Sku::class)->create($goods,$data['spec']);
                $this->goodsRepository->update($goods->id,
                    ['sku_id' => $this->goodsProductRepository->getMinSkuId($goods->id),'sku_num'=>count($data['spec'])]);
            }
            if (isset($data['add_attr'])) {
                app(Attribute::class)->bindGoods($goods->id, $data['add_attr']);
            }

            if (isset($data['add_spec'])) {
                app(TestSpec::class)->bindGoods($goods->id, $data['add_spec']);
            }
            event(new GoodsEvent($goods->id, 'added'));
            return $goods;
        });

        return $goods->id;
    }

    /**
     * @param $id
     * @param $data
     */
    public function update($goodsId,$data) {
        $priceSection = $this->goodsProductRepository->getPriceSection($data['spec']);
        $data['price'] = $priceSection[0];
        $data['max_price'] = $priceSection[1];
        $data['logistics_id'] = isset($data['logistics_id']) ? $data['logistics_id'] : null;
        \DB::transaction(function() use ($goodsId,$data) {
            $goods = $this->goodsRepository->find($goodsId);
            $goods->update($data);
            if (isset($data['imgs'])) {
                $this->goodsImagesRepository->updates($goods->id, $data['imgs']);
            }

            if (isset($data['attr'])) {
                $this->goodsAttrRepository->updates($goods->id, $data['attr']);
            }
            if(isset($data['spec'])) {
                app(Sku::class)->update($goods,$data['spec']);
                $this->goodsRepository->update($goods->id,
                    ['sku_id' => $this->goodsProductRepository->getMinSkuId($goods->id)]);
            }
            event(new GoodsEvent($goodsId, 'updated'));
        });
    }

    public function show($id) {
      $data = $this->goodsRepository->with(['skuInfo', 'units'])->find($id);

      return $data;
    }

    public function destroy($id) {
        $ok = $this->goodsRepository->delete($id);
        event(new GoodsEvent($id, 'destroyed'));
        return $ok;
    }

    /**
     * 上架
     * @param $goodsId
     */
    public function up($goodsId) {
        \DB::transaction(function() use ($goodsId) {
            $this->goodsRepository->update($goodsId,['status' => 1]);
            $this->goodsProductRepository->upGoods($goodsId);
            event(new GoodsEvent($goodsId, 'upped'));
        });
    }

    /**
     * 上架
     * @param $goodsId
     */
    public function down($goodsId) {

        \DB::transaction(function() use ($goodsId) {
            $this->goodsRepository->update($goodsId,['status' => 0]);
            $this->goodsProductRepository->downGoods($goodsId);
            event(new GoodsEvent($goodsId, 'downed'));
        });
    }

    /**
     * 是否有该店铺存在
     *
     * @param $storeId
     * @return mixed
     */
    public function isHasStore($storeId)
    {
        return $this->goodsRepository->findBy("store_id", $storeId);
    }

    /**
     * 是否有该分类存在
     *
     * @param $cateId
     * @return mixed
     */
    public function isHasCate($cateId)
    {
        return $this->goodsRepository->findBy("cate_id", $cateId);
    }


    public function deductStock($skuId,$number) {
        $obj = ShopGoodsProductModel::find($skuId);
        $edit_info['stock'] = \DB::raw("stock-$number");
        $ok = ShopGoodsProductModel::where('id',$skuId)->where(\DB::raw("stock-$number"),">=",0)->update($edit_info);
        if(!$ok) {
            throw new DatabaseException($obj->name . "库存不足");
        }
        return $ok;
    }

    public function addStock($skuId,$number) {
        $edit_info['stock'] = \DB::raw("stock+$number");
        return ShopGoodsProductModel::where('id',$skuId)->update($edit_info);
    }

    /**
     * 获取按热度排序的推荐列表
     *
     * @param int $page
     * @param int $perPage
     *
     * @return mixed
     */
    public function getRecommendHotList(int $page = 1, int $perPage = 6)
    {
        return $this->goodsRepository->getByCriteria(new Recommend())->paginate($perPage, ['*'], $page);
    }
}
