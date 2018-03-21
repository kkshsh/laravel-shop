<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 19/03/2018
 * Time: 14:38
 */

namespace SimpleShop\Commodity;


use Illuminate\Support\Facades\DB;
use SimpleShop\Commodity\Models\ShopFaq;

class Faq
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function getListByGoodsId($id)
    {
        return ShopFaq::where('goods_id', $id)->get();
    }

    /**
     * @param array $data
     */
    public function update(array $data)
    {
        DB::transaction(function () use ($data) {
            // 清空该数据
            ShopFaq::where('goods_id', $data[0]['goods_id'])->delete();
            // 再插入
            ShopFaq::insert($data);
        });
    }
}