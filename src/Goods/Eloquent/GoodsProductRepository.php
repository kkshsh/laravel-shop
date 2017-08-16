<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace Commodity\Goods\Eloquent;

use Commodity\Goods\Criteria\GoodslUp;
use Commodity\Repository\Repository;
use Commodity\Spec;


class GoodsProductRepository extends Repository {

    public function model() {
        return 'Commodity\Models\ShopGoodsProductModel';
    }

    /**
     *获取价格区间
     * @param $data
     * @return array
     */
    public function getPriceSection($data) {
        $minPrice = $data[key($data)]['price'];
        $maxPrice = 0;
        foreach($data as $val) {
            $minPrice = $val['price']<$minPrice ? $val['price'] : $minPrice ;
            $maxPrice = $val['price']>$maxPrice ? $val['price'] : $maxPrice ;
        }

        return [$minPrice,$maxPrice];
    }


    public function getMinSkuId($spuId) {
        return $this->model->where("goods_id",$spuId)->min('id');
    }

    /**
     * 添加
     * @param $data
     * @return bool|static
     */
    public function add($goodsObj,$data) {
        $add['goods_id'] = $goodsObj->id;
        $add['sku_name'] = Spec::info()->getNameByValues($data['spec_value']);
        $add['name'] = $goodsObj->name . $add['sku_name'];
        $add['price'] = $data['price'];
        $add['market_price'] = isset($data['market_price']) ? $data['market_price'] : "";
        $add['cost_price'] = isset($data['cost_price']) ? $data['cost_price'] : "";
        $add['weight'] = isset($data['weight']) ? $data['weight'] : "";
        $add['limit_purchase'] = isset($data['limit_purchase']) ? $data['limit_purchase'] : "";
        $add['stock'] = $data['stock'];
        $add['spec'] = json_encode($data['spec_value']);

        $add['spec_md5'] = Spec::info()->getSpecMd5ByValueIds($data['spec_value'],$goodsObj->id);
        $trashEd = $this->model->withTrashed()->where('spec_md5',$add['spec_md5'])->first();
        if($trashEd) {
            $this->model->withTrashed()->where('spec_md5',$add['spec_md5'])->restore();
            $obj = parent::updateRich($trashEd->id,$add);
            return $obj;
        }
        return $obj = $this->model->create($add);

    }

    public function getBySpec($goodId,array $specValue) {
       $spec_md5 =  Spec::info()->getSpecMd5ByValueIds($specValue, $goodId);

        return $this->model->where('spec_md5',$spec_md5)->first();
    }

    /**
     * 商品上架
     * @param $goodsId
     */
    public function upGoods($goodsId) {
        return parent::update($goodsId,['status'=>1],'goods_id');
    }

    /**
     * 商品下架
     */
    public function downGoods($goodsId) {
        return parent::update($goodsId,['status'=>0],'goods_id');
    }



    public function getCountByGoods($goodsId) {
        return $this->model->where("goods_id",$goodsId)->count();
    }
    /**
     * 获取上架数量
     * @param $goodsId
     */
    public function getUpCount($goodsId) {
        return $this->model->where("goods_id",$goodsId)->where("status",1)->count();
    }

    /**
     * 获取上架数量
     * @param $goodsId
     */
    public function getDownCount($goodsId) {
        return $this->model->where("goods_id",$goodsId)->where("status",0)->count();
    }



    /**
     * 根据商品ID删除
     * @param $goods_id
     * @return mixed
     */
    public function deleteByGoods($goods_id) {
        return $this->model->where('goods_id',$goods_id)->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getSpuBySku(int $id)
    {
        $obj = $this->getModel()->find($id);

        return $obj->goods;
    }
}