<?php
namespace SimpleShop\Commodity\Models;
/**
 *  @description 商品规格值表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2017-01-06
 *
 */
class ShopSpecValueModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'shop_spec_value';
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
                           'cate_id',
                           'spec_id',
                           'sort'
                           ];

    public function specInfo(){
        return $this->hasOne('SimpleShop\Commodity\Models\ShopSpecModel', 'id', 'spec_id');
    }

                                
}