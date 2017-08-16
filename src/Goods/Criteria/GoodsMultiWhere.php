<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace Commodity\Goods\Criteria;
use Commodity\Criteria\Criteria;

use Commodity\Contracts\RepositoryInterface as Repository;


class GoodsMultiWhere extends Criteria {

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
        if(isset($this->search['id']) && $this->search['id']) {
            $model = $model->where('id',$this->search['id']);
        }

        if(isset($this->search['name']) && $this->search['name']) {
            $model = $model->where('name','like',"%"  . trim($this->search['name']) . "%");
        }
        if(isset($this->search['cate_id']) && $this->search['cate_id']) {
            $model = $model->where('cate_id',$this->search['cate_id']);
        }
        if(isset($this->search['store_id']) && $this->search['store_id']) {
            $model = $model->where('store_id',$this->search['store_id']);
        }
        if (isset($this->search['store_name']) && $this->search['store_name']) {
            $model = $model->where('store_name', 'like', "%" . $this->search['store_name'] . "%");
        }

        if(isset($this->search['sku_id']) && $this->search['sku_id']) {
            $model = $model->where('sku_id',$this->search['sku_id']);
        }

        if (isset($this->search['status']) && is_numeric($this->search['status'])) {
            $model = $model->where('status',$this->search['status']);
        }
        return $model;
    }

}