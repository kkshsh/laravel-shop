<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace Commodity\Brand\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Commodity\Exceptions\Exception;
use Commodity\Models\ShopBrandModel;
use Commodity\Models\ShopCategoryBrandModel;
use Commodity\Repository\Repository;

class BrandRepository extends Repository
{

    public function model()
    {
        return 'Commodity\Models\ShopBrandModel';
    }


    /**
     * 添加
     *
     * @param $data
     *
     * @return Model
     * @throws Exception
     */
    public function add($data)
    {
        if ($this->getByName($data['name'])) {
            throw new Exception('品牌已存在，请不要重复添加');
        }
        \DB::beginTransaction();
        $obj = $this->model->create($data);
        if (! $obj) {
            \DB::rollBack();

            throw new Exception('品牌保存失败');
        }

        \DB::commit();

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
    public function update($id, array $data)
    {
        $obj = $this->model->find($id);
        if (! $obj) {
            return false;
        }
        if ($data['name'] != $obj->name) {
            if ($this->getByName($data['name'])) {
                throw new Exception('品牌已存在，请不要重复添加');
            }
        }
        \DB::beginTransaction();
        $ok = $obj->update($data);
        if (! $ok) {
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
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * 根据名称获取内容
     *
     * @param $name
     *
     * @return mixed
     */
    public function getByName($name)
    {
        return parent::findBy('name', $name);
    }

    /**
     * 获取除去了自己的品牌列表
     *
     * @author jiangzhiheng
     *
     * @param $id
     * @param string $name
     *
     * @return Collection
     */
    public function getExceptSelf($id, $name = '')
    {
        $query = ShopBrandModel::whereRaw("not exists (select 1 from shop_category_brand where shop_category_brand.cate_id = ? and shop_category_brand.brand_id = shop_brand.id)",
            [$id]);
        if ($name != '') {
            $query->where('shop_brand.name', 'like', "%{$name}%");
        }
        $query = $query->select([
            'id',
            'name',
            'logo'
        ])->get();
//        dd(\DB::getQueryLog());

        return $query;
    }

    /**
     * 获取自己已经选了的品牌
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return mixed
     */
    public function getSelf($id)
    {
        return ShopBrandModel::join('shop_category_brand', 'shop_brand.id', '=', 'shop_category_brand.brand_id')
            ->where('shop_category_brand.cate_id', '=', $id)
            ->select([
                'shop_brand.id as id',
                'shop_brand.name as name',
                'shop_brand.logo as logo',
            ])
            ->get();
    }
}