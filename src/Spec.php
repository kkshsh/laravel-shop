<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity;


use SimpleShop\Commodity\Repositories\Criteria\SpecGoodsId;
use SimpleShop\Commodity\Repositories\GoodsProductRepository;
use SimpleShop\Commodity\Repositories\GoodsRepository;
use SimpleShop\Commodity\Repositories\GoodsSpecRepository;

/**
 * This is the attr class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Spec
{
    protected $goodsRepository;
    protected $goodsProductRepository;
    protected $goodsAttrRepository;
    protected $attribute;

    public function __construct(GoodsRepository $goodsRepository,
                                GoodsProductRepository $goodsProductRepository,
                                GoodsSpecRepository $goodsSpecRepository
                            )
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsSpecRepository = $goodsSpecRepository;
    }


    public function getValueIdsGoods($goodsId) {
        return $this->goodsSpecRepository->pushCriteria(new SpecGoodsId($goodsId))->pluck('spec_value_id');
    }
    public function groupGoodsItem($goodsId) {
        $data = $this->goodsSpecRepository->getByGoods($goodsId);
        $temp = [];
        foreach ($data as $item) {
            $temp[$item['spec_name']][] = $item;
        }
        return $temp;
    }
}
