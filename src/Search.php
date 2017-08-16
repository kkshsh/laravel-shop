<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/14
 * Time: 上午11:50
 */

namespace Commodity;


use Commodity\Search\RepositoryInterface;

class Search
{
    /**
     * 注入的仓库对象
     *
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Search constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 获取cate对应的搜索项
     *
     * @param $cateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParentByCate($cateId)
    {
        // 获取该分类的父分类
        $cate = Cate::search()->find($cateId);

        $cates = $this->repository->getByCate($cateId);

        if ($cate->pid != 0) {
            $collection = $this->repository->getByCate($cate->pid);
            if ($collection->isNotEmpty()) {
                foreach ($collection as $item) {
                    $cates->prepend($item);
                }
            }
        }

        return $cates;
    }

    /**
     * 总是获取自己cate当前的搜索项
     *
     * @param $cateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCate($cateId)
    {
        return $this->repository->getByCate($cateId);
    }

    /**
     * 添加或修改
     *
     * @param array $data
     * @return bool
     */
    public function addOrUpdate(array $data)
    {
        return $this->repository->addOrUpdate($data);
    }

    /**
     * 删除一个值
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function all()
    {
        return $this->repository->all();
    }
}