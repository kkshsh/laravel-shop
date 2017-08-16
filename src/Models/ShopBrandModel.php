<?php
/**
 *------------------------------------------------------
 * ShopBrandModel.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/12/19 11:31
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Models;

class ShopBrandModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "shop_brand";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'name',
        'logo',
        'description'
    ];

    public function cateBrand()
    {
        return $this->hasOne(ShopCategoryBrandModel::class, 'brand_id', 'id');
    }

}