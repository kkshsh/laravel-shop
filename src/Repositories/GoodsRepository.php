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

use SimpleShop\Commodity\Models\ShopGoodsModel;
use SimpleShop\Repositories\Eloquent\Repository;

/**
 * Class LogisticsRepository
 * @package SimpleShop\Logistics\Repositories
 */
class GoodsRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return ShopGoodsModel::class;
    }

}
