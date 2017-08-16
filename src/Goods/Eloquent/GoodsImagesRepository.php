<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace Commodity\Goods\Eloquent;

use Commodity\Exceptions\Exception;
use Commodity\Repository\Repository;


class GoodsImagesRepository extends Repository
{

    public function model()
    {
        return 'Commodity\Models\ShopGoodsImagesModel';
    }


    public function adds($goods_id, $imgs)
    {
        $add['goods_id'] = $goods_id;
        foreach ($imgs as $img) {
            $add['path'] = $img['path'];
            $add['desc'] = $img['desc'];
            $obj = $this->model->create($add);
            if (! $obj) {
                return false;
            }
        }
        return true;
    }


    public function deleteByGoods($goods_id)
    {
        return $this->model->where('goods_id', $goods_id)->delete();
    }

}