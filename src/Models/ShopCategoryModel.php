<?php
/**
 *------------------------------------------------------
 * ShopCategoryModel.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/12/19 11:31
 * @version   V1.0
 *
 */

namespace LWJ\Commodity\Models;

class ShopCategoryModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "shop_category";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'name',
        'pid',
        'tree',
        'sort',
        'cate_dir',
        'title',
        'keyword',
    ];

    public function child()
    {
        return $this->hasMany(static::class, 'pid', 'id');
    }
}