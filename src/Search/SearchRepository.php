<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/14
 * Time: 上午11:11
 */

namespace Commodity\Search;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Commodity\Exceptions\Exception;
use Commodity\Models\ShopSearchModel;
use DB;

class SearchRepository implements RepositoryInterface
{
    /**
     * 获取一条单体的search
     *
     * @param $id
     * @return \stdClass|Model
     */
    public function find($id)
    {
        return ShopSearchModel::find($id);
    }

    /**
     * 获取search通过cate
     *
     * @param $cateId
     * @return Collection
     */
    public function getByCate($cateId)
    {
        return ShopSearchModel::cateId($cateId)->get();
    }

    /**
     * 添加或修改
     *
     * @param array $data
     * @return bool
     */
    public function addOrUpdate(array $data)
    {
        // 首先看是否有id,有的话为修改,没有为添加:
        if (empty($data['id'])) {
            return $this->add($data);
        }

        // 处理修改的逻辑
        return $this->update($data);
    }

    /**
     * 添加
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    protected function add(array $data)
    {
        if ($this->getSearch($data)) {
            throw new Exception('当前分类下已经有了该搜索项,' . "搜索项为\"{$data['name']}\"");
        }

        ShopSearchModel::create($data);

        return true;
    }

    /**
     * 修改
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    protected function update(array $data)
    {
        $id = $data['id'];
        unset($data['id']);
        ShopSearchModel::whereId($id)->update($data);

        return true;
    }

    /**
     * 获取value里的name值
     *
     * @param array $values
     * @return array
     */
    protected function valueName(array $values)
    {
        $output = array_column($values, 'name');

        return $output;
    }

    /**
     * 检查search表中是否已经有了同样的数据
     *
     * @param array $data
     * @return \stdClass|Model
     */
    protected function getSearch(array $data)
    {
        return ShopSearchModel::cateId($data['cate_id'])->name($data['name'])->first();
    }

    /**
     * 删除一条记录
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return ShopSearchModel::destroy($id);
    }

    /**
     * 获取全部记录
     *
     * @return Collection
     */
    public function all()
    {
        return ShopSearchModel::all();
    }
}