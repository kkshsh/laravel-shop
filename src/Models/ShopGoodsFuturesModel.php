<?php
namespace Commodity\Models;
/**
 *  @description 期货表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2017-01-05
 *
 */
class ShopGoodsFuturesModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'shop_goods_futures';
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
                           'cate_id',
                           'name',
                           'tags',
                           'brand_id',
                           'origin_id',
                           'port_id',
                           'level',
                           'days',
                           'spec',
                           'amount',
                           'on_sale',
                           'min_num',
                           'max_num',
                           'deposit',
                           'brand_desc',
                           'product_desc'
                           ];
                                
}