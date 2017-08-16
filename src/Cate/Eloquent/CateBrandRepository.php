<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace Commodity\Cate\Eloquent;


use Commodity\Exceptions\Exception;
use Commodity\Repository\Repository;

class CateBrandRepository extends Repository {

    public function model() {
        return 'Commodity\Models\ShopCategoryBrandModel';
    }


    /**
     * 添加
     * @param $data
     * @return bool|static
     */
    public function add($cateId,$brandId) {
        \DB::beginTransaction();
        $obj = $this->model->create(['cate_id'=>$cateId,'brand_id'=>$brandId]);
        if(!$obj) {
            \DB::rollBack();
            return false;
        }

        \DB::commit();
        return $obj;

    }
    /**
     * 删除分类下所有品牌
     * @param $cateId
     * @return bool
     */
    public function deleteByCate($cateId) {
        return $this->model->where("cate_id", $cateId)->delete();
    }

    /**
     * 删除品牌
     * @param $cateId
     * @param $brandId
     * @return mixed
     */
    public function deleteByCateBrand($cateId,$brandId) {
        return $this->model->where("cate_id", $cateId)->where("brand_id", $brandId)->delete();
    }
}