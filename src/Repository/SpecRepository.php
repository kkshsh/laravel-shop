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
use SimpleShop\Commodity\Models\ShopGoodsSpecModel;
use SimpleShop\Commodity\Models\ShopSpecModel;
use SimpleShop\Commodity\Models\ShopSpecValueModel;

class SpecRepository
{

    private $shopSpecModel;
    private $shopSpecValueModel;
    private $shopGoodsSpecModel;

    public function __construct(
        ShopSpecModel $shopSpecModel,
        ShopSpecValueModel $shopSpecValueModel,
        ShopGoodsSpecModel $shopGoodsSpecModel
    ) {
        $this->shopSpecModel = $shopSpecModel;
        $this->shopSpecValueModel = $shopSpecValueModel;
        $this->shopGoodsSpecModel = $shopGoodsSpecModel;
    }


    /**
     * 添加
     *
     * @param $data
     *
     * @return Model
     * @throws \Exception
     */
    public function add($data)
    {
        $obj = $this->shopSpecModel->create($data);

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
     * @throws \Exception
     */
    public function update($id, $data)
    {
        $obj = $this->shopSpecModel->find($id);
        if ( ! $obj) {
            return false;
        }

        \DB::beginTransaction();
        $ok = $obj->update($data);
        if ($ok === false) {
            \DB::rollBack();
            throw new \Exception('保存/更新销售属性失败!', 500);
        }
        \DB::commit();

        return true;
    }

    private function getByName($name)
    {
        return $this->shopSpecModel->where("name", $name)->first();
    }

    /**
     * 删除
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    public function delete($id)
    {
        //检查商品是否存在
        if ($this->shopGoodsSpecModel->where("spec_id", $id)->first()) {
            throw new Exception("属性已经被使用，不能删除", 409);
        }

        return $this->shopSpecModel->destroy($id);
    }


    /**
     * @param $idValues
     */
    public function getSpecMd5ByValueIds($idValues)
    {
        return md5(json_encode(sort($idValues)));
    }

    /**
     * @param $specVale获取属性名称
     */
    public function getSpecNameByValueIds($idValues)
    {
        $obj = $this->shopSpecValueModel->whereIn('id', $idValues)->get();
        $specName = '';
        foreach ($obj as $val) {
            $specName .= $val->specInfo->name . ":" . $val->name . ",";
        }
        if ($specName) {
            $specName = substr($specName, 0, -1);
        }

        return $specName;
    }

    public function searchCateId($cateId)
    {
        $data = $this->shopSpecModel->select("id", "name")->where("cate_id", $cateId)->get();
        if ( ! $data) {
            return false;
        }
        $data = $data->toArray();

        foreach ($data as &$item) {
            $value = $this->shopSpecValueModel->select("id", 'name')->where("spec_id", $item['id'])->get();
            if ( ! $value) {
                $value = [];
            }
            $item['value'] = $value->toArray();
        }

        return $data;
    }


}