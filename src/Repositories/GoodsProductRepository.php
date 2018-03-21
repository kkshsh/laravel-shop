<?php
/**
 *------------------------------------------------------
 * LogisticsRepository.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Repositories;

use SimpleShop\Commodity\Models\ShopGoodsProductModel;
use SimpleShop\Repositories\Eloquent\Repository;
use SimpleShop\Spec\Spec;

/**
 * Class LogisticsRepository
 * @package SimpleShop\Logistics\Repositories
 */
class GoodsProductRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return ShopGoodsProductModel::class;
    }

    /**
     *获取价格区间
     * @param $data
     * @return array
     */
    public function getPriceSection($data) {
        $minPrice = $data[key($data)]['price'];
        $maxPrice = $minPrice;
        foreach($data as $val) {
            $minPrice = $val['price']<$minPrice ? $val['price'] : $minPrice ;
            $maxPrice = $val['price']>$maxPrice ? $val['price'] : $maxPrice ;
        }
        $minPrice = $minPrice!="" ? $minPrice : null;
        $maxPrice = $maxPrice!="" ? $maxPrice : null;

        return [$minPrice,$maxPrice];
    }


    public function getMinSkuId($spuId) {
        $data = $this->model->select('id')->where("goods_id",$spuId)->orderBy('price','ASC')->first();
        if($data) {
            return $data->id;
        }
        return '';
    }

    /**
     * 添加
     * @param $data
     * @return bool|static
     */
    public function add($goodsObj,$data) {
        $add['goods_id'] = $goodsObj->id;

        $add['sku_name'] = app(Spec::class)->getNameByValues($data['spec_value']);
        $add['name'] = $goodsObj->name . $add['sku_name'];
        if(isset($data['price']) && $data['price']!=='' ) $add['price'] = $data['price'];
        if(isset($data['market_price']) ) $add['market_price'] = $data['market_price'];
        if(isset($data['cost_price']) ) $add['cost_price'] = $data['cost_price'];
        if(isset($data['weight']) ) $add['weight'] = $data['weight'];
        if(isset($data['limit_purchase']) ) $add['limit_purchase'] = $data['limit_purchase'];
        if(isset($data['stock']) ) $add['stock'] = $data['stock'];
        $add['spec'] = json_encode($data['spec_value']);
        $add['spec_md5'] = app(Spec::class)->getSpecMd5ByValueIds($data['spec_value'],$goodsObj->id);
        $trashEd = $this->model->withTrashed()->where('spec_md5',$add['spec_md5'])->first();

        if($trashEd) {
            $this->model->withTrashed()->where('spec_md5',$add['spec_md5'])->restore();
            $obj = parent::updateRich($trashEd->id,$add);
            return $obj;
        }

        return $obj = $this->model->create($add);

    }

    private function getSpecValuesByData($specData) {
        $arr = [];
        foreach ($specData as $item) {
            foreach ($item as $specVal) {
                array_merge($arr,$specVal['id']);
            }
        }
        return $arr;
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
