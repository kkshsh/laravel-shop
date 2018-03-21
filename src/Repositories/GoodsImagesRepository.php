<?php
/**
 *------------------------------------------------------
 * LogisticsRepository.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Repositories;

use SimpleShop\Commodity\Models\ShopGoodsImagesModel;
use SimpleShop\Repositories\Eloquent\Repository;

/**
 * Class LogisticsRepository
 * @package SimpleShop\Logistics\Repositories
 */
class GoodsImagesRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return ShopGoodsImagesModel::class;
    }

    public function adds($goods_id,array $imgs)
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

    /**
     * @param $goods_id
     * @param $imgs
     */
    public function updates($goods_id,array $imgs){
        $this->deleteByGoods($goods_id);
        $this->adds($goods_id,$imgs);
    }


    public function deleteByGoods($goods_id)
    {
        return $this->model->where('goods_id', $goods_id)->delete();
    }

}
