<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 19/03/2018
 * Time: 15:39
 */

namespace SimpleShop\Commodity\Models;


use Illuminate\Database\Eloquent\Model;

class ShopFaq extends Model
{
    /**
     * 数据表名
     */
    protected $table = "shop_faqs";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'goods_id',
        'question',
        'answer'
    ];
}