<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace LWJ\Commodity\Goods\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use LWJ\Commodity\Exceptions\Exception;
use LWJ\Commodity\Models\ShopAttributeModel;
use LWJ\Commodity\Models\ShopAttributeValueModel;
use LWJ\Commodity\Models\ShopGoodsAttributeModel;
use LWJ\Commodity\Repository\Repository;


class GoodsAttrRepository extends Repository {

    public function model() {
        return 'LWJ\Commodity\Models\ShopGoodsAttributeModel';
    }

    /**
     * 添加
     * @param $data
     * @return bool|static
     */
    public function add($goods_id,$value_id) {
        $attributeValueModel = new ShopAttributeValueModel();
        $data = $attributeValueModel->find($value_id);
        if(!$data) {
            throw new Exception("不存在的属性ID" . $value_id);
        }
        $add['goods_id'] = $goods_id;
        $add['cate_id'] =  $data->cate_id;
        $add['attr_id'] = $data->attr_id;
        $add['attr_value_id'] = $data->id;
        return $obj = $this->model->create($add);
    }

    public function addOrNew($goods_id, $valueId) {
        $attributeValueModel = new ShopAttributeValueModel();
        $data = $attributeValueModel->find($valueId);
        if(!$data) {
//            throw new Exception("不存在的属性ID" . $valueId);
            //不存在就创建
            $attributeValueModel->create([

            ]);
        }
        $add['goods_id'] = $goods_id;
        $add['cate_id'] =  $data->cate_id;
        $add['attr_id'] = $data->attr_id;
        $add['attr_value_id'] = $data->id;
        return $obj = $this->model->create($add);
    }

    /**
     * @param $goods_id
     * @param $value_ids
     * @return bool
     */
    public function adds($goods_id,$value_ids) {
        foreach($value_ids as $value_id) {
            $ok = $this->add($goods_id,$value_id);
            if(! $ok) {
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
        $goodsAttributeModel = new ShopGoodsAttributeModel();
        $shopAttributeModel = new ShopAttributeModel();
        $attributeValueModel = new ShopAttributeValueModel();
        $tGoodAttr = $goodsAttributeModel->getTable();
        $tAttr = $shopAttributeModel->getTable();
        $tAttrValue = $attributeValueModel->getTable();
        $data = $goodsAttributeModel->select(\DB::raw("$tAttr.id as attr_id"),
            \DB::raw("$tAttr.name as attr_name"),
            \DB::raw("$tAttrValue.id as attr_value_id"),
            \DB::raw("$tAttrValue.name as attr_value_name")
        )
            ->where("$tGoodAttr.goods_id",$goods_id)
            ->leftJoin($tAttr,"$tAttr.id","=","$tGoodAttr.attr_id")
            ->leftJoin($tAttrValue,"$tAttrValue.id","=","$tGoodAttr.attr_value_id")
            ->get()->toArray();

        return $data;
    }

    public function deleteByGoods($goods_id) {
        return $this->model->where('goods_id',$goods_id)->delete();
    }

}