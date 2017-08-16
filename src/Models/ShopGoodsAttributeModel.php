<?php
namespace LWJ\Commodity\Models;
/**
 *  @description 商品与属性对应表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2017-01-11
 *
 */
class ShopGoodsAttributeModel extends BaseModel
{
    public $timestamps = true;
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'shop_goods_attribute';
    /**
                主键
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
        'attr_id',
        'attr_value_id'
    ];

    public function attrValue()
    {
        return $this->hasOne(ShopAttributeValueModel::class, 'id', 'attr_value_id');
    }

    public function attr()
    {
        return $this->hasOne(ShopAttributeModel::class, 'id', 'attr_id');
    }
}