<?php
namespace LWJ\Commodity\Models;
/**
 *  @description 商品属性表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2017-01-05
 *
 */
class ShopAttributeModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'shop_attribute';
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
                           'name',
                           'attr_value',
                           'cate_id',
                           'type',
                           'show',
                           'sort'
                           ];
                                
}