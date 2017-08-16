<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace Commodity\Cate;

use App\Exceptions\IsUsedException;
use Illuminate\Support\Collection;
use Commodity\Cate;
use Commodity\Cate\Eloquent\CateRepository;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Info
{
    /**
     * The Commodity  (aka the issuer).
     *
     * @var Commodity;
     */
    protected $cateRepository;

    public function __construct(CateRepository $cateRepository)
    {
        $this->cateRepository = $cateRepository;

    }


    /**
     * 添加分类
     */
    public function add($data)
    {
        return $this->cateRepository->add($data);
    }


    /**
     * 修改分类
     */
    public function update($id, $data)
    {
        return $this->cateRepository->update($id, $data);
    }

    /**
     * 删除分类
     */
    public function delete($id)
    {
        return $this->cateRepository->delete($id);
    }

    /**
     * 获取全部分类及下面的子分类
     *
     * @param $id
     * @return array|Collection
     */
    public function getChildCate($id)
    {
        $data = $this->cateRepository->getChildCate($id);
        $reData = [];
        $data->each(function ($item) use (&$reData) {
            /** @var \Illuminate\Database\Eloquent\Collection $children */
            $children = $item->child;
            $reData[] = $item;
            $this->getChild($children, $reData);
        });

        return collect($reData);
    }

    /**
     * 检查该分类是否已经使用了
     *
     * @param $cateId
     * @return bool
     */
    public function cateIsUsed($cateId)
    {
        $id = $this->cateRepository->cateIsUsed($cateId);
        if ($id->isNotEmpty()) {
            throw new IsUsedException('该分类已经被使用了');
        }

        return true;
    }

    /**
     * 用来递归的私有方法
     * @param Collection $collection
     * @param array $reData
     * @return bool
     */
    private function getChild($collection, &$reData = [])
    {
        if ($collection->isNotEmpty()) {
            $collection->each(function ($item) use (&$reData) {
                $reData[] = $item;
                if ($item->child->isNotEmpty()) {
                    $this->getChild($item->child, $reData);
                }
            });
        }

        return true;
    }
}
