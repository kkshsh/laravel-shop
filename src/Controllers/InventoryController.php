<?php
/**
 * Created by PhpStorm.
 * User: coffee
 * Date: 17-1-17
 * Time: 下午4:29
 */

namespace  SimpleShop\Commodity\Controllers;


use Illuminate\Http\Request;
use SimpleShop\Commodity\Commodity;
use SimpleShop\Commodity\Goods\Criteria\ProductGoods;
use SimpleShop\Commodity\Goods\Criteria\ProductMultiWhere;

class InventoryController extends Controller
{
    /**
     * 库存首页
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $rules = [
            'search' => 'required|array',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        $reData = Commodity::search()->sku()->pushCriteria(new ProductGoods())->pushCriteria(
            new ProductMultiWhere($request->input('search')));

        return $this->paginate($reData);
    }

    /**
     * sku上线
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function up(Request $request)
    {
        $rules = [
            'id'     => 'required|integer',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Commodity::sku()->up($request->input('id'));
            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * sku下线
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function down(Request $request)
    {
        $rules = [
            'id'     => 'required|integer',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Commodity::sku()->down($request->input('id'));
            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}