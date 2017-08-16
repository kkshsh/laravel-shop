<?php

namespace SimpleShop\Commodity\Models;

/**
 * @description 商品与属性对应表
 * @author  wangzhoudong  <admin@yijinba.com>;
 * @version    1.0
 * @date 2017-01-11
 *
 */
class ShopGoodsSpecModel extends BaseModel
{
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'shop_goods_spec';
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
        'goods_id',
        'cate_id',
        'spec_id',
        'spec_value_id'
    ];

    public function specValue()
    {
        return $this->hasOne(ShopSpecValueModel::class, 'id', 'spec_value_id');
    }

    public function spec()
    {
        return $this->hasOne(ShopSpecModel::class, 'id', 'spec_id');
    }

}