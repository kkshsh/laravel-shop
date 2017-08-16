<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/14
 * Time: 上午11:12
 */

namespace LWJ\Commodity\Search;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * 获取一条单体的search
     *
     * @param $id
     * @return \stdClass|Model
     */
    public function find($id);

    /**
     * 获取search通过cate
     *
     * @param $cateId
     * @return Collection
     */
    public function getByCate($cateId);

    /**
     * 添加或修改
     *
     * @param array $data
     * @return bool
     */
    public function addOrUpdate(array $data);

    /**
     * 删除一条记录
     *
     * @param $id
     * @return bool
     */
    public function delete($id);

    /**
     * 获取全部记录
     *
     * @return Collection
     */
    public function all();
}