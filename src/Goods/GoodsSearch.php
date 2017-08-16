<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity\Goods;

use SimpleShop\Commodity\Goods\Criteria\LineGoods;
use SimpleShop\Commodity\Goods\Eloquent\GoodsAttrRepository;
use SimpleShop\Commodity\Goods\Eloquent\GoodsProductRepository;
use SimpleShop\Commodity\Goods\Eloquent\GoodsRepository;
use SimpleShop\Commodity\Goods\Eloquent\GoodsSpecRepository;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class GoodsSearch
{
    /**
     * The Commodity  (aka the issuer).
     */
    protected $goodsRepository;
    protected $goodsAttrRepository;
    protected $goodsProductRepository;
    protected $goodsSpecRepository;

    public function __construct(
        GoodsRepository $goodsRepository,
        GoodsProductRepository $goodsProductRepository,
        GoodsAttrRepository $goodsAttrRepository,
        GoodsSpecRepository $goodsSpecRepository
    ) {
        $this->goodsRepository = $goodsRepository;
        $this->goodsAttrRepository = $goodsAttrRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsSpecRepository = $goodsSpecRepository;
    }


    /**
     * 商品的详情
     *
     * @param int $goodsId 商品ID
     * @return array
     */
    public function findGoods($goodsId)
    {
        $data['base'] = $this->goodsRepository->find($goodsId);
        $data['spec'] = $this->goodsSpecRepository->getByGoods($goodsId);
        $data['attr'] = $this->goodsAttrRepository->getByGoods($goodsId);
        return $data;
    }

    /**
     * 获取商品仓库
     * @return GoodsRepository
     */
    public function spu()
    {
        return $this->goodsRepository;
    }

    /**
     * 终端查询，会过滤的下架，禁用的商品
     * @return GoodsProductRepository
     *
     */

    public function terminalSpu()
    {
        $this->goodsRepository->pushCriteria(new LineGoods());
    }

    public function sku()
    {
        return $this->goodsProductRepository;
    }

    /**
     *
     * 终端查询，会过滤的下架，禁用的商品
     *
     */
    public function terminalSku()
    {
        return $this->goodsProductRepository->pushCriteria(new LineGoods());
    }


    public function goodsCommend($goods_id,$num) {
        return $this->goodsRepository->goodsCommend($goods_id,$num);
    }

    /**
     * 通过skuId来寻找spu
     *
     * @param int $id
     * @return mixed
     */
    public function findSpuBySku(int $id)
    {
        return $this->goodsProductRepository->getSpuBySku($id);
    }
}

