<?php

namespace LWJ\Commodity\Models;

/**
 * @description 商品SPU表
 * @author  wangzhoudong  <admin@yijinba.com>;
 * @version    1.0
 * @date 2017-01-05
 *
 */
class ShopGoodsModel extends BaseModel
{
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'shop_goods';
    /**
     * 主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = [
        'store_id',
        'store_name',
        'price',
        'max_price',
        'name',
        'cover_path',
        'brand_id',
        'tags',
        'cate_id',
        'description',
        'content',
        'hot',
        'sort',
        'status',
        'verify',
        'begin_num',
        'unit',
        'price_sku_id'
    ];


    /**
     * SKU信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skuInfo()
    {
        return $this->hasMany('LWJ\Commodity\Models\ShopGoodsProductModel', 'goods_id', 'id');
    }

    public function attrInfo()
    {
        return $this->hasMany('LWJ\Commodity\Models\ShopGoodsAttributeModel', 'goods_id', 'id');
    }

    /**
     * 获取商品分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cate()
    {
        return $this->hasOne(ShopCategoryModel::class, 'id', 'cate_id');
    }

    /**
     * 获取商品图片
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pics()
    {
        return $this->hasMany(ShopGoodsImagesModel::class, 'goods_id', 'id');
    }

    public function brand()
    {
        return $this->hasOne(ShopBrandModel::class, 'id', 'brand_id');
    }
}