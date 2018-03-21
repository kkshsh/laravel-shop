<?php
/**
 *------------------------------------------------------
 * SkuController.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Https\Controllers;

use Illuminate\Http\Request;
use SimpleShop\Commodity\Sku;
use SimpleShop\Commons\Https\Controllers\Controller;
use SimpleShop\Commons\Utils\ReturnJson;

class SkuController extends Controller
{

    public $skuService;

    /**
     * SkuController constructor.
     * @param Sku $skuService
     */
    public function __construct(Sku $skuService)
    {
        $this->skuService = $skuService;
    }

    /**
     * 列表
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->getRouteParam($request);
        $data = $this->skuService->search($request->all(),
            [$this->routeParam['sort'] => $this->routeParam['order']],
            $this->routeParam['page'],
            $this->routeParam['limit']);
        return ReturnJson::paginate($data);
    }


    /**
     * 上架
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function up($id)
    {

        $this->skuService->up($id);
        return $this->success();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiUp(Request $request)
    {
        $ids = $request->input('ids');

        foreach ($ids as $id) {
            $this->skuService->up($id);
        }
        return $this->success();
    }

    /**
     * 下架
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function down($id)
    {

        $this->skuService->down($id);
        return $this->success();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiDown(Request $request)
    {
        $ids = $request->input('ids');

        foreach ($ids as $id) {
            $this->skuService->down($id);
        }

        return $this->success();
    }

    public  function goodsList($goodsId) {
        $data = $this->skuService->all(['goods_id'=>$goodsId]);
        foreach ($data  as &$item) {
            $item->spec = json_decode($item->spec);
        }
        return $this->success($data);
    }


}
