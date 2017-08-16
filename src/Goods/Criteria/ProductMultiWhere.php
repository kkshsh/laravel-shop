<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace LWJ\Commodity\Goods\Criteria;
use LWJ\Commodity\Criteria\Criteria;

use LWJ\Commodity\Contracts\RepositoryInterface as Repository;
use LWJ\Commodity\Models\ShopGoodsModel;


class ProductMultiWhere extends Criteria {

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
        if(isset($this->search['id']) && $this->search['id']) {
            $model = $model->where("$tModel.id",$this->search['id']);
        }
        if(isset($this->search['goods_id']) && $this->search['goods_id']) {
            $model = $model->where("$tModel.goods_id",$this->search['goods_id']);
        }


        if(isset($this->search['name']) && $this->search['name']) {
            $model = $model->where("$tModel.name",'like',"%"  . trim($this->search['name']) . "%");
        }
        if(isset($this->search['status']) && is_numeric($this->search['status'])) {
            $model = $model->where("$tModel.status", $this->search['status']);
        }
        if(isset($this->search['cate_id']) && $this->search['cate_id']) {
            $model = $model->where("$tGoods.cate_id",$this->search['cate_id']);
        }
        if(isset($this->search['store_id']) && $this->search['store_id']) {
            $model = $model->where("$tGoods.store_id",$this->search['store_id']);
        }
        if(isset($this->search['store_name']) && $this->search['store_name']) {
            $model = $model->where("$tGoods.store_name", 'like', "%{$this->search['store_name']}%");
        }

        return $model;
    }

}