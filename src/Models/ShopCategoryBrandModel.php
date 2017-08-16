<?php
/**
 *------------------------------------------------------
 * ShopCategoryBrandModel.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/12/19 11:31
 * @version   V1.0
 *
 */

namespace LWJ\Commodity\Models;

class ShopCategoryBrandModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "shop_category_brand";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'cate_id',
        'brand_id'
    ];

    public function brand()
    {
        return $this->belongsTo(ShopBrandModel::class, 'brand_id', 'id');
    }

}