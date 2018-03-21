<?php
/**
 *------------------------------------------------------
 * ShopCommodityCommonModel.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/12/19 11:31
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Models;

class ShopCommodityCommonModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "shop_commodity_common";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'name',
        'sub_name',
        'brand_id',
        'tags',
        'cate_id',
        'type_id',
        'description',
        'content',
        'in_home',
        'top',
        'likes',
        'like_goods',
        'hot',
        'page_title',
        'meta_keyword',
        'meta_description',
        'logistics_since',
        'logistics_deliver',
        'sort'
    ];

}