<?php
namespace Commodity\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @description 商品SKU表
 * @author  wangzhoudong  <admin@yijinba.com>;
 * @version    1.0
 * @date 2017-01-05
 *
 */
class ShopGoodsProductModel extends BaseModel
{
    use SoftDeletes;

    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'shop_goods_product';
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
        'name',
        'sku_name',
        'price',
        'market_price',
        'cost_price',
        'weight',
        'limit_purchase',
        'stock',
        'hot',
        'on_sale',
        'spec',
        'spec_md5',
        'status',
        'spec_str',
    ];

    public function attrChoose()
    {
        return $this->hasMany(ShopGoodsAttributeModel::class, 'goods_id', 'goods_id');
    }

    public function specChoose()
    {
        return $this->hasMany(ShopGoodsSpecModel::class, 'goods_id', 'goods_id');
    }

    public function pics()
    {
        return $this->hasMany(ShopGoodsImagesModel::class, 'id', 'goods_id');
    }

    public function goods()
    {
        return $this->belongsTo(ShopGoodsModel::class, 'goods_id', 'id');
    }
}