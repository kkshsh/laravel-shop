<?php
namespace  SimpleShop\Commodity\Controllers;

use Illuminate\Http\Request;
use SimpleShop\Commodity\Controllers\Traits\ReturnFormat;
use SimpleShop\Commodity\Controllers\Traits\ValidateHandler;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * 父控制类类
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ReturnFormat, ValidateHandler;

    protected $_user;
    protected $routeParam;

    public function __construct()
    {
        view()->share('_user', auth()->user());
    }

    /**
     * 获取路由参数
     * @param Request $request
     */
    protected function getRouteParam(Request $request)
    {
        //获取路由参数
        $this->routeParam['limit'] = $request->route('limit') ? intval($request->route('limit')) : PAGE_NUMS;
        $this->routeParam['page'] = $request->route('page') ? intval($request->route('page')) : 1;
        $this->routeParam['sort'] = $request->route('sort') ? trim($request->route('sort')) : 'created_at';
        $this->routeParam['order'] = $request->route('order') ? trim($request->route('order')) : 'DESC';
        $request->merge(['page' => $this->routeParam['page']]);
    }

}
