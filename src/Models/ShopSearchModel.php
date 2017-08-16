<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/14
 * Time: 上午11:02
 */

namespace SimpleShop\Commodity\Models;


use Illuminate\Database\Eloquent\Builder;

class ShopSearchModel extends BaseModel
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'shop_search';

    /**
     * 主键ID
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 分页页数
     *
     * @var int
     */
    protected $perPage = PAGE_NUMS;

    /**
     * 允许赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'cate_id',
        'sort'
    ];

    /**
     * 通过cateId查询
     *
     * @param Builder $query
     * @param $cateId
     * @return Builder
     */
    public function scopeCateId($query, $cateId)
    {
        return $query->where('cate_id', $cateId);
    }

    /**
     * 通过sort排序
     *
     * @param Builder $query
     * @param string $order
     * @return Builder
     */
    public function scopeOrder($query, $order = 'asc')
    {
        return $query->orderBy('sort', $order);
    }

    /**
     * 通过name查询
     *
     * @param Builder $query
     * @param string $name
     * @return Builder
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * 定义获取value时的访问器
     *
     * @param $value
     * @return array
     */
    public function getValueAttribute($value)
    {
        return explode(',', $value);
    }
}