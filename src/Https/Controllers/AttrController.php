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
use SimpleShop\Commodity\Attr;
use SimpleShop\Commodity\Commodity;
use SimpleShop\Commodity\Https\Requests\Api\SubmitRequest;
use SimpleShop\Commons\Https\Controllers\Controller;
use SimpleShop\Commons\Utils\ReturnJson;

class AttrController extends Controller
{

    public $attrService;


    /**
     * AttrController constructor.
     * @param Attr $attrService
     */
    public function __construct(Attr $attrService)
    {
        $this->attrService = $attrService;
    }


    /**
     * 列表
     *
     * @param Request $request
     * @return mixed
     */
    public function getListByGoods($goodsId)
    {
        /** @var TYPE_NAME $goodsId */
        return  ReturnJson::success($this->attrService->getListByGoods($goodsId));
    }

    public function getValueIdsGoods($goodId) {
        return ReturnJson::success($this->attrService->getValueIdsGoods($goodId));
    }

    public function groupGoodsItem($goodsId) {
        return ReturnJson::success($this->attrService->groupGoodsItem($goodsId));
    }


}
