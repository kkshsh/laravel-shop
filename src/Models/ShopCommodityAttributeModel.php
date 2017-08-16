<?php
/**
 *------------------------------------------------------
 * ShopCommodityAttributeModel.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/12/19 11:31
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Models;

class ShopCommodityAttributeModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "shop_commodity_attribute";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'common_id',
        'commodity_id',
        'attr_name',
        'attr_value',
        'attr_sort'
    ];

}