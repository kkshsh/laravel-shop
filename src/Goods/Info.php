<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace Commodity\Goods;

use App\Exceptions\IsUsedException;
use Illuminate\Support\Collection;
use Commodity\Cate;
use Commodity\Goods\Check\FilterData;
use Commodity\Goods\Eloquent\GoodsAttrRepository;
use Commodity\Goods\Eloquent\GoodsImagesRepository;
use Commodity\Goods\Eloquent\GoodsProductRepository;
use Commodity\Goods\Eloquent\GoodsRepository;
use Commodity\Goods\Eloquent\GoodsSpecRepository;
use Mockery\CountValidator\Exception;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Info
{
    use FilterData;

    protected $goodsRepository;
    protected $goodsProductRepository;
    protected $goodsAttrRepository;
    protected $goodsImagesRepository;
    protected $goodsSpecRepository;

    public function __construct(
        GoodsRepository $goodsRepository,
        GoodsProductRepository $goodsProductRepository,
        GoodsAttrRepository $goodsAttrRepository,
        GoodsImagesRepository $goodsImagesRepository,
        GoodsSpecRepository $goodsSpecRepository
    ) {
        $this->goodsRepository = $goodsRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsAttrRepository = $goodsAttrRepository;
        $this->goodsImagesRepository = $goodsImagesRepository;
        $this->goodsSpecRepository = $goodsSpecRepository;
    }


    /**
     * 添加商品
     * @param $data
     * @param $attr
     * @param $spec
     * @return bool|mixed
     */
    public function add($data, $attr, $spec)
    {
        $data = $this->infoData($data);
        $priceSection = $this->goodsProductRepository->getPriceSection($spec);

        $data['price'] = $priceSection[0];
        $data['max_price'] = $priceSection[1];
        $img = isset($data['imgs']) ? $data['imgs'] : [];
        \DB::beginTransaction();
        $obj = $this->goodsRepository->create($data);
        if (! $obj) {
            \DB::rollBack();
            return false;
        }
        if ($img) {
            $this->goodsImagesRepository->adds($obj->id, $img);
        }


        if ($attr) {
            //添加Attr
            $ok = $this->goodsAttrRepository->adds($obj->id, $attr);
            if (! $ok) {
                \DB::rollBack();
                return false;
            }
        }

        if (! $this->addSpec($obj, $spec)) {
            \DB::rollBack();
            return false;
        }


        \DB::commit();
        return $obj;
    }


    private function addSpec($goods, $spec)
    {
        if (! $spec) {
            return true;
        }
        $specValues = [];
        foreach ($spec as $value) {
            $ok = $this->goodsProductRepository->add($goods, $value);
            if (! $ok) {
                return false;
            }
            $specValues = array_merge($specValues, $value['spec_value']);
        }
        if ($specValues) {
            $ok = $this->goodsSpecRepository->adds($goods->id, array_unique($specValues));
            if (! $ok) {
                return false;
            }
        }
        $ok = $this->goodsRepository->update($goods->id,
            ['sku_id' => $this->goodsProductRepository->getMinSkuId($goods->id)]);

        return true;
    }

    /**
     * 修改商品
     */
    public function update($goodsId, $data)
    {
        $data = $this->infoData($data);


        $obj = $this->goodsRepository->find($goodsId, ['id', 'name']);
        if ($data['name'] != $obj->name) {
            if ($this->goodsRepository->getByName($data['name'])) {
                throw new Exception('商品名称已存在');
            }
        }
        return $this->goodsRepository->update($goodsId, $data);
    }

    /**
     * 修改属性
     * @param $goodsId
     * @param $attr
     * @return bool
     * @throws \Commodity\Exceptions\Exception
     */
    public function updateAttr($goodsId, $attr)
    {
        $obj = $this->goodsRepository->find($goodsId, ['id']);
        if (! $obj) {
            throw new Exception('商品不存在');
        }

        \DB::beginTransaction();
        //清空原有商品
        $ok = $this->goodsAttrRepository->deleteByGoods($goodsId);
        if ($ok === false) {
            \DB::rollBack();
            throw new Exception('删除属性失败');
        }
        //添加Attr
        $ok = $this->goodsAttrRepository->adds($goodsId, $attr);
        if (! $ok) {
            \DB::rollBack();
            throw new \Commodity\Exceptions\Exception('添加属性失败');
        }

        \DB::commit();
        return true;
    }

    /**
     * 修改图片
     * @param $goodsId
     * @param $attr
     */
    public function updateImages($goodsId, $imgs)
    {
        $obj = $this->goodsRepository->find($goodsId, ['id']);
        if (! $obj) {
            throw new Exception('商品不存在');
        }

        \DB::beginTransaction();
        //清空原有商品
        $ok = $this->goodsImagesRepository->deleteByGoods($goodsId);
        if ($ok === false) {
            \DB::rollBack();
            throw new Exception('删除原图片失败');
        }
        //添加Attr
        $ok = $this->goodsImagesRepository->adds($goodsId, $imgs);
        if (! $ok) {
            \DB::rollBack();
            return false;
        }
        \DB::commit();
        return true;
    }


    /**
     * 修改属性
     * @param $goodsId
     * @param $spec
     */
    public function updateSpec($goodsId, $spec)
    {
        $obj = $this->goodsRepository->find($goodsId);
        if (! $obj) {
            throw new Exception('商品不存在');
        }

        \DB::beginTransaction();
        //清空原有商品
        $ok = $this->goodsSpecRepository->deleteByGoods($goodsId);
        if ($ok === false) {
            \DB::rollBack();
            throw new Exception('删除属性失败1');
        }
        $ok = $this->goodsProductRepository->deleteByGoods($goodsId);
        if ($ok === false) {
            \DB::rollBack();
            throw new Exception('删除属性失败2');
        }

        //Spec

        if (! $this->addSpec($obj, $spec)) {
            \DB::rollBack();
            return false;
        }

        $priceSection = $this->goodsProductRepository->getPriceSection($spec);
        $data['price'] = $priceSection[0];
        $data['max_price'] = $priceSection[1];
        $obj->update($data);

        \DB::commit();
        return true;
    }

    /**
     * 删除商品
     */
    public function delete($goodId)
    {
        return $this->goodsRepository->delete($goodId);
    }


    /**
     * 上架
     * @param $goodsId
     */
    public function up($goodsId)
    {
        \DB::beginTransaction();
        $ok = $this->goodsRepository->update($goodsId, ['status' => 1]);
        if (! $ok) {
            return false;
            \DB::rollBack();

        }
        $ok = $this->goodsProductRepository->upGoods($goodsId);
        if (! $ok) {
            return false;
            \DB::rollBack();
        }
        \DB::commit();
        return true;
    }

    /**
     * 下架
     * @param $goodsId
     */
    public function down($goodsId)
    {


        \DB::beginTransaction();
        $ok = $this->goodsRepository->update($goodsId, ['status' => 0]);
        if (! $ok) {
            return false;
            \DB::rollBack();

        }
        $ok = $this->goodsProductRepository->downGoods($goodsId);
        if (! $ok) {
            return false;
            \DB::rollBack();
        }
        \DB::commit();
        return true;
    }

    public function checkName($name)
    {
        return $this->goodsRepository->getByName($name);
    }

    /**
     * @param $cateId
     * @return bool
     */
    public function cateIsUsed($cateId)
    {
        /** @var Collection $cates 找到该分类下的所有分类 */
        $cates = Cate::info()->getChildCate($cateId);
        $id = $this->goodsRepository->cateIsUsed($cates->pluck('id')->toArray());
        if ($id->isNotEmpty()) {
            throw new IsUsedException('该分类已经被使用了');
        }

        return true;
    }

}
