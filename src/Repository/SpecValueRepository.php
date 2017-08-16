<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace LWJ\Commodity\Repository;


use Illuminate\Database\Eloquent\Model;
use LWJ\Commodity\Exceptions\Exception;
use LWJ\Commodity\Models\ShopGoodsSpecModel;
use LWJ\Commodity\Models\ShopSpecModel;
use LWJ\Commodity\Models\ShopSpecValueModel;

class SpecValueRepository  {

    use SpecCache;

    private $specModel;
    private $specValueModel;
    private $shopGoodsSpecModel;

    public function __construct(ShopSpecModel $specModel,
                                ShopSpecValueModel $specValueModel,
                                ShopGoodsSpecModel $shopGoodsSpecModel
    )
    {
        $this->specModel = $specModel;
        $this->specValueModel = $specValueModel;
        $this->shopGoodsSpecModel = $shopGoodsSpecModel;
    }

    /**
     * 添加
     *
     * @param $specId
     * @param $name
     * @param int $sort
     *
     * @return Model
     */
    public function add($specId,$name,$sort=0) {
        $obj = $this->getByName($specId,$name);
        if($obj) {
            return $obj;
        }
        $attr = $this->specModel->find($specId);
        $add['name'] = $name;
        $add['spec_id'] = $specId;
        $add['cate_id'] = $attr->cate_id;
        $add['sort'] = $sort;

        $obj = $this->specValueModel->create($add);
        if($obj){
            $this->updateCache($specId,$this->specModel,$this->specValueModel);
        }
        return $obj;
    }

    /**
     * 修改
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id,$data) {

        $obj = $this->specValueModel->find($id);
        if(!$obj) {
            return false;
        }
        $check = $this->getByName($obj->spec_id,$data['name']);
        if($check) {
            return false;
        }
        \DB::beginTransaction();
        $ok = $obj->update($data);
        if(!$ok) {
            \DB::rollBack();
            return false;
        }
        $this->updateCache($obj->spec_id,$this->specModel,$this->specValueModel);
        \DB::commit();
        return true;
    }

    private function getByName($specId,$name) {
        return $this->specValueModel->where("spec_id",$specId)->where("name",$name)->first();
    }


    public function find($id) {
        return $this->specValueModel->find($id);
    }

    /**
     * 删除
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    public function delete($id) {
        $obj =  $this->specValueModel->find($id);
        if(!$obj) {
            throw new Exception("不存在属性值", 404);
        }
        //检查商品是否存在
        if($this->shopGoodsSpecModel->where("spec_value_id",$id)->first()) {
            throw new Exception("属性值已经被使用，不能删除", 409);
        }


        $ok = $obj->forceDelete();
        if($ok){
            $this->updateCache($obj->spec_id,$this->specModel,$this->specValueModel);
        }
        return $ok;
    }



}