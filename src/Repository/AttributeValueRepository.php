<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace SimpleShop\Commodity\Repository;

use SimpleShop\Commodity\Exceptions\Exception;
use SimpleShop\Commodity\Models\ShopAttributeModel;
use SimpleShop\Commodity\Models\ShopAttributeValueModel;
use SimpleShop\Commodity\Models\ShopGoodsAttributeModel;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;

class AttributeValueRepository
{

    use AttributeCache;
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

        public function model() {
        return $this->attributeValueModel;
    }

    /**
     * 添加
     *
     * @param $data
     *
     * @return static
     */
    public function add($attrId, $name, $sort = 0)
    {

        $obj = $this->getByName($attrId, $name);
        if ($obj) {
            return $obj;
        }
        $attr = $this->attributeModel->find($attrId);
        $add['name'] = $name;
        $add['attr_id'] = $attrId;
        $add['cate_id'] = $attr->cate_id;
        $add['sort'] = $sort;

        $obj = $this->attributeValueModel->create($add);
        if ($obj) {
            $this->updateCache($attrId, $this->attributeModel, $this->attributeValueModel);
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
     * @throws Exception
     */
    public function update($id, $data)
    {

        $obj = $this->attributeValueModel->find($id);
        if ( ! $obj) {
            throw  new Exception("没有找到对应的属性值", 500);
        }
        $check = $this->getByName($obj->attr_id, $data['name']);
        if ($check) {
            return false;
        }
        \DB::beginTransaction();
        $ok = $obj->update($data);
        if ( ! $ok) {
            \DB::rollBack();

            throw  new Exception("修改失败", 500);
        }
        $this->updateCache($obj->attr_id, $this->attributeModel, $this->attributeValueModel);
        \DB::commit();

        return true;
    }

    private function getByName($attrId, $name)
    {
        return $this->attributeValueModel->where("attr_id", $attrId)->where("name", $name)->first();
    }

    /**
     * 删除
     *
     * @param $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        $obj = $this->attributeValueModel->find($id);
        if ( ! $obj) {
            throw  new Exception("没有找到对应的属性值");
        }
        if($this->shopGoodsAttributeModel->where("attr_value_id",$id)->first()) {
            throw new Exception("已近有商品再使用改属性值，不能删除");
        }
        $ok = $obj->forceDelete();
        if ($ok) {
            $this->updateCache($obj->attr_id, $this->attributeModel, $this->attributeValueModel);
        }

        return $ok;
    }


}