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
use SimpleShop\Commodity\Commodity;
use SimpleShop\Commodity\Https\Requests\Api\SubmitRequest;
use SimpleShop\Commons\Exceptions\ResourceNotFindException;
use SimpleShop\Commons\Https\Controllers\Controller;
use SimpleShop\Commons\Utils\ReturnJson;

class CommodityController extends Controller
{

    public $commodityService;

    /**
     * @param Commodity $commodityService
     */
    public function __construct(Commodity $commodityService)
    {
        $this->commodityService = $commodityService;
    }

    /**
     * 列表
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $this->getRouteParam($request);
        $data = $this->commodityService->search($request->all(),
            [$this->routeParam['sort'] => $this->routeParam['order']],
            $this->routeParam['page'],
            $this->routeParam['limit']);
        return ReturnJson::paginate($data);
    }

    /**
     * 获取所有
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $data = $this->commodityService->getAll();
        return ReturnJson::success($data);
    }

    /**
     * 获取详情
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = $this->commodityService->show($id);
        if (is_null($data)) {
            throw new ResourceNotFindException('没有找到对应的资源');
        }
        $data->load('pics');
        return ReturnJson::success($data);
    }

    /**
     * 更新
     *
     * @param               $id
     * @param SubmitRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, SubmitRequest $request)
    {
        $this->commodityService->update($id,$request->all());
        return ReturnJson::success(['id'=>$id]);
    }

    /**
     * 增添
     *
     * @param SubmitRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SubmitRequest $request)
    {
        $resData = $this->commodityService->create($request->all());
        return ReturnJson::success(['id'=>$resData]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->commodityService->destroy($id);
        return ReturnJson::success(['id'=>$id]);
    }


    /**
     * 上架
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function up($id)
    {
        $this->commodityService->up($id);
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
            $this->commodityService->up($id);
        }

        return $this->success();
    }

    /**
     * 下架
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function down($id)
    {

        $this->commodityService->down($id);
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
            $this->commodityService->down($id);
        }

        return $this->success();
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function recommendHotList(Request $request)
    {
        return ReturnJson::paginate($this->commodityService->getRecommendHotList($request->input('page', 1), 10));
    }
}
