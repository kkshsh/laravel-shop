<?php
/**
 *------------------------------------------------------
 * ShopGoodsImagesModel.php
 *------------------------------------------------------
 *
 * @author    wangzhoudong@@foxmail.com
 * @date      2017/02/06 07:48
 * @version   V1.0
 *
 */

namespace Commodity\Models;

class ShopGoodsImagesModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "shop_goods_images";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'goods_id',
        'path',
        'desc'
    ];

}