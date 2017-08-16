<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity\Cate;

use SimpleShop\Commodity\Cate;
use SimpleShop\Commodity\Cate\Eloquent\CateBrandRepository;
use DB;
use SimpleShop\Commodity\Models\ShopBrandModel;
use SimpleShop\Commodity\Models\ShopCategoryBrandModel;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Brand
{
    /**
     * The Commodity  (aka the issuer).
     *
     * @var SimpleShop\Commodity;
     */
    protected $cateBrandRepository;

    public function __construct(CateBrandRepository $cateBrandRepository)
    {
        $this->cateBrandRepository = $cateBrandRepository;

    }

    /**
     * 添加品牌
     *
     * @param $cateId
     * @param $brandId
     *
     * @return void
     */
    public function add($cateId, $brandId)
    {
        DB::transaction(
            function () use ($cateId, $brandId) {
                //首先删除自己下面的品牌
                $this->cateBrandRepository->deleteByCate($cateId);

                //再保存当前的
                if (! is_array($brandId)) {
                    $brandId = (array)$brandId;
                }

                foreach ($brandId as $item) {
                    $this->cateBrandRepository->add($cateId, $item);
                }
            });
    }

    /**
     * 从自己身上取消品牌
     *
     * @author jiangzhiheng
     * @param int $cateId
     * @param array|string $brandIds
     */
    public function remove($cateId, array $brandIds)
    {
        DB::transaction(
            function () use ($cateId, $brandIds) {
                foreach ($brandIds as $item) {
                    $this->cateBrandRepository->deleteByCateBrand($cateId, $item);
                }
            });
    }

    /**
     * 删除该分类下的所有品牌
     *
     * @author jiangzhiheng
     * @param int $cateId
     */
    public function removeAll(int $cateId)
    {
        $this->cateBrandRepository->deleteByCate($cateId);
    }

    /**
     * 删除品牌
     *
     * @param $cateId
     * @param $brandId
     *
     * @return bool|static
     */
    public function delete($cateId, $brandId)
    {
        if (is_array($brandId)) {
            foreach ($brandId as $id) {
                $this->cateBrandRepository->deleteByCateBrand($cateId, $id);
            }

            return true;
        } else {
            return $this->cateBrandRepository->deleteByCateBrand($cateId, $brandId);
        }
    }

    /**
     * 通过分类id获取品牌
     *
     * @param $cateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCateId($cateId)
    {
        // 首先获取该cateId是否还有下层
        $pid = Cate::search()->with(['child'])->find($cateId);
        $array = [];

        if ($pid->pid != 0) {
            foreach ($pid->child as $item) {
                $array[] = $item->id;
            }
        } else {
            foreach ($pid->child as $item) {
                $id = $item->child->pluck('id')->toArray();
                $array = array_merge($array, $id);
            }
        }
        // 利用cate_id去查询
        return ShopCategoryBrandModel::with('brand')
            ->select([
                'id',
                'cate_id',
                'brand_id',
            ])
            ->whereIn('cate_id', $array)
            ->get();
    }


}
