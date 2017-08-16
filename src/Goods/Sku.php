<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity\Goods;

use App\Exceptions\ServiceErrorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use SimpleShop\Commodity\Commodity;
use SimpleShop\Commodity\Goods\Check\FilterData;
use SimpleShop\Commodity\Goods\Eloquent\GoodsAttrRepository;
use SimpleShop\Commodity\Goods\Eloquent\GoodsProductRepository;
use SimpleShop\Commodity\Goods\Eloquent\GoodsRepository;
use SimpleShop\Commodity\Goods\Eloquent\GoodsSpecRepository;
use Mockery\CountValidator\Exception;
use DB;

/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Sku
{
    use FilterData;
    /**
     * The Commodity  (aka the issuer).
     */
    protected $goodsRepository;
    protected $goodsProductRepository;
    protected $goodsAttrRepository;
    protected $goodsSpecRepository;

    public function __construct(
        GoodsRepository $goodsRepository,
        GoodsProductRepository $goodsProductRepository,
        GoodsAttrRepository $goodsAttrRepository,
        GoodsSpecRepository $goodsSpecRepository
    ) {
        $this->goodsRepository = $goodsRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsAttrRepository = $goodsAttrRepository;
        $this->goodsSpecRepository = $goodsSpecRepository;
    }

    public function find($id)
    {
        return $this->goodsProductRepository->find($id);
    }

    /**
     * 上架
     *
     * @param int $id
     *
     * @return bool
     * @throws \Exception
     */
    public function up($id)
    {
        $data = $this->goodsProductRepository->find($id);
        if (! $data) {
            throw new \Exception('传入的ID不对!');
        }
        \DB::beginTransaction();

        $ok = $this->goodsProductRepository->update($id, ['status' => 1]);

        if (false === $ok) {
            \DB::rollBack();

            throw new \Exception('更改失败!');
        }
        $ok = $this->goodsRepository->update($data->goods_id, ['status' => 1]);
        if (false === $ok) {
            \DB::rollBack();

            throw new \Exception('更改失败!');
        }

        \DB::commit();

        return true;
    }

    /**
     * 下架
     *
     * @param int $id
     *
     * @return bool
     * @throws \Exception
     */
    public function down($id)
    {
        $data = $this->goodsProductRepository->find($id);
        if (! $data) {
            throw new \Exception('传入的ID不对!');
        }

        \DB::beginTransaction();
        $ok = $this->goodsProductRepository->update($id, ['status' => 0]);
        if (false === $ok) {
            \DB::rollBack();

            throw new \Exception('更改失败!');
        }
        $allCount = $this->goodsProductRepository->getCountByGoods($data->goods_id);
        $count = $this->goodsProductRepository->getDownCount($data->goods_id);
        if ($count === $allCount) {
            $ok = $this->goodsRepository->update($data->goods_id, ['status' => 0]);
            if (false === $ok) {
                \DB::rollBack();

                throw new \Exception('更改失败!');
            }
        }
        \DB::commit();

        return true;
    }

    /**
     * 根据选择的销售属性获取SKU Data
     * @param $goodId
     * @param array $specValue
     */
    public function getBySpec($goodId, array $specValue)
    {
        return $this->goodsProductRepository->getBySpec($goodId, $specValue);

    }

    /**
     * 修改sku
     *
     * @author jiangzhiheng
     *
     * @param int $id
     * @param array $data
     *
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->goodsProductRepository->update($id, $data);
    }

    /**
     * 扣减库存
     * @param $skuId
     * @param $goodsNum
     */
    public function deductStock($skuId, $goodsNum)
    {
        $edit_info['stock'] = \DB::raw("stock-$goodsNum");
        return $this->goodsProductRepository->getModel()->where('id', $skuId)->where(\DB::raw("stock-$goodsNum"), ">=",
            0)->update($edit_info);
    }

    /**
     * 获取sku列表的value值
     * @param Collection|LengthAwarePaginator $collection
     * @return LengthAwarePaginator|Collection
     */
    public function getListAttrValue($collection)
    {
        if ($collection instanceof Collection || $collection instanceof LengthAwarePaginator) {
            $collection->transform(function ($item) {
                /** @var Collection $goodsAttr */
                $goodsAttr = $item->attrChoose;
                $goodsAttr->transform(function ($i) use ($item) {
                    $value = $i->attrValue->name;
                    $attr = $i->attr->name;
                    $item->$attr = $value;
                    return $item;
                });
                return $item;
            });

            return $collection;
        }

        throw new ServiceErrorException('传入的参数类型不是' . Collection::class . '或' . LengthAwarePaginator::class);
    }

    /**
     * @param Collection|LengthAwarePaginator $collection
     * @return LengthAwarePaginator|Collection
     */
    public function getListSpecValue($collection)
    {
        if ($collection instanceof Collection || $collection instanceof LengthAwarePaginator) {
            $collection->transform(function ($item) {
                /** @var Collection  $goodsSpec */
                $goodsSpec = $item->specChoose;
                $goodsSpec->transform(function ($value) use ($item) {
                    $specValue = $value->specValue->name;
                    $spec = $value->spec->name;
                    $item->$spec = $specValue;
                    return $item;
                });
                return $item;
            });

            return $collection;
//            $collection->transform(function ($item) {
//                $skuName = $item->sku_name;
//                $nameArray = explode(',', $skuName);
//                foreach ($nameArray as $name) {
//                    $tempArray = explode(':', $name);
//                    $one = $tempArray[0];
//                    $two = $tempArray[1];
//                    $item->$one = $two;
//                }
//                return $item;
//            });

//            return $collection;
        }

        throw new ServiceErrorException('传入的参数类型不是' . Collection::class . '或' . LengthAwarePaginator::class);
    }
}
