<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace SimpleShop\Commodity\Repository;

use Illuminate\Database\Eloquent\Model;
use SimpleShop\Commodity\Exceptions\Exception;
use SimpleShop\Commodity\Models\ShopAttributeModel;
use SimpleShop\Commodity\Models\ShopAttributeValueModel;
use SimpleShop\Commodity\Models\ShopGoodsAttributeModel;

class AttributeRepository
{

    private $attributeModel;
    private $attributeValueModel;
    private $shopGoodsAttributeModel;


    public function __construct(
        ShopAttributeModel $attributeModel,
        ShopAttributeValueModel $attributeValueModel,
        ShopGoodsAttributeModel $shopGoodsAttributeModel
    ) {
        $this->attributeModel = $attributeModel;
        $this->attributeValueModel = $attributeValueModel;
        $this->shopGoodsAttributeModel = $shopGoodsAttributeModel;

    }

    /**
     * 添加
     *
     * @param array $data
     *
     * @return Model
     * @throws \Exception
     */
    public function add(array $data)
    {
        $obj = $this->getByName($data['cate_id'],$data['name']);
        if ($obj) {
            return false;
        }
        if ($obj) {
            return $obj;
        }
        $obj = $this->attributeModel->create($data);

        if ($obj === false) {
            throw new \Exception('保存属性失败', 500);
        }

        return $obj;
    }

    /**
     * 修改
     *
     * @param $id
     * @param $data
     *
     * @return bool
     */
    public function update($id, $data)
    {

        $obj = $this->attributeModel->find($id);
        if ( ! $obj) {
            return false;
        }

        \DB::beginTransaction();
        $ok = $obj->update($data);
        if ( ! $ok) {
            \DB::rollBack();

            return false;
        }
        \DB::commit();

        return true;
    }

    private function getByName($cateId,$name)
    {
        return $this->attributeModel->where("cate_id",$cateId)->where("name", $name)->first();
    }

    /**
     * 删除
     *
     * @param $obj
     *
     * @return bool
     */
    public function delete($id)
    {
        $obj = $this->attributeModel->find($id);
        if ( ! $obj) {
            throw  new Exception("没有找到对应的属性");
        }
        if ($this->shopGoodsAttributeModel->where("attr_id", $id)->first()) {
            throw new Exception("已近有商品再使用改属性值，不能删除");
        }
        $ok = $obj->forceDelete();

        return $ok;
    }

    public function searchCateId($cateId)
    {
        $data = $this->attributeModel->select("id", "name", "type")->where("cate_id", $cateId)->get();

        if ( ! $data) {
            return false;
        }
        $data = $data->toArray();

        foreach ($data as &$item) {
            $value = $this->attributeValueModel->select("id", 'name')->where("attr_id", $item['id'])->get();
            if ( ! $value) {
                $value = [];
            }
            $item['value'] = $value->toArray();
        }

        return $data;
    }
}