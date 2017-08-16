<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace Commodity\Cate\Eloquent;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Commodity\Exceptions\Exception;
use Commodity\Models\ShopCategoryModel;
use Commodity\Repository\Repository;
use DB;

class CateRepository extends Repository {

    public function model() {
        return 'Commodity\Models\ShopCategoryModel';
    }

    /**
     * 获取分页对象
     *
     * @author jiangzhiheng
     * @return LengthAwarePaginator|Collection
     */
    public function orderAll()
    {
        return $this->model->orderBy('pid')->orderBy('sort')->get();
    }

    /**
     * 添加
     * @param $data
     * @return bool|static
     */
    public function add($data) {
        \DB::beginTransaction();
        $obj = $this->model->create($data);
        if(!$obj) {
            \DB::rollBack();
            return false;
        }
        if(!$this->updateTree($obj)) {
            \DB::rollBack();
            return false;
        }
        \DB::commit();
        return $obj;

    }

    /**
     * 修改
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id,array $data) {
        \DB::beginTransaction();
        $obj = $this->model->find($id);
        if(!$obj) {
            return false;
        }
        $ok = $obj->update($data);
        if(!$ok) {
            \DB::rollBack();
            return false;
        }
        if(!$this->updateTree($obj)) {
            \DB::rollBack();
            return false;
        }
        \DB::commit();
        return true;
    }

    /**
     * 删除
     *
     * @param $id
     * @return bool
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }

    private function updateTree($obj) {
        if($obj->pid==0) {
            $obj->root_id = $obj->id;
            $obj->tree = $obj->id;
            $obj->save();
        }else{
            $parentObj = $this->model->find($obj->pid);
            $obj->root_id = $parentObj->root_id;
            $obj->tree = $parentObj->tree . "," . $obj->id;
            $obj->save();
        }
        return true;
    }

    /**
     * 获取cateDir对应的cate
     *
     * @param array $cateDir
     * @return Collection
     */
    public function getByCateDir(array $cateDir)
    {
        /** @var Collection $object */
        $object = ShopCategoryModel::whereIn('cate_dir', $cateDir)->get();

        return $object;
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getChildCate(int $id)
    {
        return ShopCategoryModel::with('child')->whereId($id)->get();
    }

    /**
     * 检查当前cateId是否在自身已经被使用了
     * @param $cateId
     * @return \Illuminate\Support\Collection
     */
    public function cateIsUsed($cateId)
    {
        $sql = /** @lang MySQL */
            <<<SQL
        SELECT `id` FROM `shop_category` WHERE `pid` = ? AND root_id = ? AND id <> ? LIMIT 1 OFFSET 0;
SQL;

        $reData = DB::select($sql, [$cateId, $cateId, $cateId]);

        return collect($reData);
    }
}