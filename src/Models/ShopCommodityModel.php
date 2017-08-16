<?php
/**
 *------------------------------------------------------
 * ShopCommodityModel.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/12/19 11:31
 * @version   V1.0
 *
 */

namespace LWJ\Commodity\Models;

class ShopCommodityModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "shop_commodity";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'common_id',
        'name',
        'price',
        'home_spu',
        'market_price',
        'limit_purchase',
        'stock',
        'page_view',
        'hot',
        'likes',
        'on_sale',
        'active_name',
        'active_price',
        'spec',
        'spec_md5',
        'spec_str'
    ];

}