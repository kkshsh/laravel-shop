<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity;


use SimpleShop\Commodity\Repositories\Criteria\AttrGoodsId;
use SimpleShop\Commodity\Repositories\Criteria\GoodsMultiWhere;
use SimpleShop\Commodity\Repositories\Criteria\GoodsOrder;
use SimpleShop\Commodity\Repositories\GoodsAttrRepository;
use SimpleShop\Commodity\Repositories\GoodsImagesRepository;
use SimpleShop\Commodity\Repositories\GoodsProductRepository;
use SimpleShop\Commodity\Repositories\GoodsRepository;

/**
 * This is the attr class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Attr
{
    protected $goodsRepository;
    protected $goodsProductRepository;
    protected $goodsImagesRepository;
    protected $goodsAttrRepository;
    protected $attribute;

    public function __construct(GoodsRepository $goodsRepository,
                                GoodsProductRepository $goodsProductRepository,
                                GoodsImagesRepository $goodsImagesRepository,
                                GoodsAttrRepository $goodsAttrRepository
                            )
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsImagesRepository = $goodsImagesRepository;
        $this->goodsAttrRepository = $goodsAttrRepository;
    }


    /**
     *
     * @param $goodId
     */
    public function getListByGoods($goodsId) {
       return      $this->goodsAttrRepository->pushCriteria(new AttrGoodsId($goodsId))->all(['id','cate_id','attr_id','attr_value_id']);
    }

    public function getValueIdsGoods($goodsId) {
        return $this->goodsAttrRepository->pushCriteria(new AttrGoodsId($goodsId))->pluck('attr_value_id');
    }

    public function groupGoodsItem($goodsId) {
        $data = $this->goodsAttrRepository->getByGoods($goodsId);
        $temp = [];
        foreach ($data as $item) {
            $temp[$item['attr_name']][] = $item;
        }
        return $temp;

    }
}
