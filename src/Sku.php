<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity;

use SimpleShop\Commodity\Events\ProductEvent;
use SimpleShop\Commodity\Repositories\Criteria\GoodsProduct;
use SimpleShop\Commodity\Repositories\Criteria\ProductMultiWhere;
use SimpleShop\Commodity\Repositories\CriteriaProduct\Order;
use SimpleShop\Commodity\Repositories\GoodsProductRepository;
use SimpleShop\Commodity\Repositories\GoodsRepository;
use SimpleShop\Commodity\Repositories\GoodsSpecRepository;

class Sku
{
    protected $goodsRepository;
    protected $goodsProductRepository;
    protected $goodsSpecRepository;

    public function __construct(GoodsRepository $goodsRepository,
                                GoodsProductRepository $goodsProductRepository,
                                GoodsSpecRepository $goodsSpecRepository
                            )
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsSpecRepository = $goodsSpecRepository;
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
        return $this->goodsProductRepository
            ->pushCriteria(new GoodsProduct($search))
            ->pushCriteria(new ProductMultiWhere($search))
            ->pushCriteria(new Order($orderBy))
            ->paginate($pageSize, ['*'], $page);
    }

    public function all(array $search = [], array $orderBy = []) {
        return $this->goodsProductRepository
            ->pushCriteria(new GoodsProduct($search))
            ->pushCriteria(new ProductMultiWhere($search))
            ->all();
    }

    public function create($goods,$spec) {

        $specValues = [];
        foreach ($spec as $value) {
            $this->goodsProductRepository->add($goods, $value);
            $specValues = array_merge($specValues, $value['spec_value']);
        }
        if ($specValues) {
            $ok = $this->goodsSpecRepository->adds($goods->id, array_unique($specValues));
        }
    }

    /**
     * @param $goods
     * @param $spec
     */
    public function update($goods,$spec) {
        //清空原有商品
        $this->goodsSpecRepository->deleteByGoods($goods->id);
        $this->goodsProductRepository->deleteByGoods($goods->id);
        $this->create($goods,$spec);
    }

    /**
     * 上架
     *
     * @param int $id
     *
     * @return bool
     * @throws \Exception
     */
    public function up($id)
    {
        \DB::transaction(function() use ($id) {
            $data = $this->goodsProductRepository->find($id);
            if (! $data) {
                throw new \Exception('传入的ID不对!');
            }
            $this->goodsProductRepository->update($id ,['status' => 1]);
            $this->goodsRepository->update($data->goods_id,['status' => 1]);
            event(new ProductEvent($id, 'upped'));
        });
        return true;
    }

    /**
     * 下架
     *
     * @param int $id
     *
     * @return bool
     * @throws \Exception
     */
    public function down($id)
    {
        \DB::transaction(function() use ($id) {
            $data = $this->goodsProductRepository->find($id);
            if (! $data) {
                throw new \Exception('传入的ID不对!');
            }
            $this->goodsProductRepository->update($id, ['status' => 0]);
            $allCount = $this->goodsProductRepository->getCountByGoods($data->goods_id);
            $count = $this->goodsProductRepository->getDownCount($data->goods_id);
            if ($count === $allCount) {
                $this->goodsRepository->update($data->goods_id,['status' => 0]);
            }
            event(new ProductEvent($id, 'downed'));
        });
        return true;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->goodsProductRepository->find($id);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getSkuListByGoodsId($id)
    {
        return $this->goodsProductRepository->findWhere(['goods_id' => $id]);
    }
}
