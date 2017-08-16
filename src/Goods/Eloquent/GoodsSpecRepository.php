<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace SimpleShop\Commodity\Goods\Eloquent;

use SimpleShop\Commodity\Exceptions\Exception;
use SimpleShop\Commodity\Models\ShopGoodsSpecModel;
use SimpleShop\Commodity\Models\ShopSpecModel;
use SimpleShop\Commodity\Models\ShopSpecValueModel;
use SimpleShop\Commodity\Repository\Repository;
use SimpleShop\Commodity\Spec;


class GoodsSpecRepository extends Repository {

    public function model() {
        return 'SimpleShop\Commodity\Models\ShopGoodsSpecModel';
    }

    /**
     * 添加
     * @param $data
     * @return bool|static
     */
    public function add($goods_id,$value_id) {
        $data = Spec::value()->find($value_id);
        if(!isset($data->id)) {
            throw new Exception("不存在的属性ID" . $value_id);
        }
        $add['goods_id'] = $goods_id;
        $add['cate_id'] =  $data->cate_id;
        $add['spec_id'] = $data->spec_id;
        $add['spec_value_id'] = $data->id;
        return $obj = $this->model->create($add);
    }

    public function adds($goods_id,array $value_ids) {
        foreach($value_ids as $value_id) {
            $ok = $this->add($goods_id,$value_id);
            if(!$ok) {
                return false;
            }
        }
        return true;
    }

    /**
     * 获取商品的属性
     * @param $goods_id
     */
    public function getByGoods($goods_id) {
        $goodsSpecModel = new ShopGoodsSpecModel();
        $specModel = new ShopSpecModel();
        $specValueModel = new ShopSpecValueModel();
        $tGoodSpec = $goodsSpecModel->getTable();
        $tSpec = $specModel->getTable();
        $tSpecValue = $specValueModel->getTable();
        $data = $goodsSpecModel->select(\DB::raw("$tSpec.id as spec_id"),
            \DB::raw("$tSpec.name as spec_name"),
            \DB::raw("$tSpecValue.id as spec_value_id"),
            \DB::raw("$tSpecValue.name as spec_value_name")
        )
            ->where("$tGoodSpec.goods_id",$goods_id)
            ->leftJoin($tSpec,"$tSpec.id","=","$tGoodSpec.spec_id")
            ->leftJoin($tSpecValue,"$tSpecValue.id","=","$tGoodSpec.spec_value_id")
            ->get()->toArray();
        return $data;
    }

    /**
     * 根据商品ID删除属性
     * @param $goods_id
     * @return mixed
     */
    public function deleteByGoods($goods_id) {
        return $this->model->where('goods_id',$goods_id)->delete();
    }


}