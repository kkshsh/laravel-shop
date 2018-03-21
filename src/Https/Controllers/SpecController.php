<?php
/**
 *------------------------------------------------------
 * LogisticsController.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Https\Controllers;

use Illuminate\Http\Request;
use SimpleShop\Commodity\Spec;
use SimpleShop\Commons\Https\Controllers\Controller;
use SimpleShop\Commons\Utils\ReturnJson;

class SpecController extends Controller
{

    public $specService;



    public function __construct(Spec $specService)
    {
        $this->specService = $specService;
    }




    public function getValueIdsGoods($goodsId) {
        return ReturnJson::success($this->specService->getValueIdsGoods($goodsId));
    }

    public function groupGoodsItem($goodsId) {
        return ReturnJson::success($this->specService->groupGoodsItem($goodsId));
    }


}
