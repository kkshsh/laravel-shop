<?php
/**
 * Created by PhpStorm.
 * User: coffee
 * Date: 17-2-24
 * Time: 下午5:03
 */

namespace  LWJ\Commodity\Controllers;


use Illuminate\Http\Request;
use LWJ\Commodity\Cate;
use LWJ\Commodity\Commodity;
use LWJ\Commodity\Goods\Criteria\ProductGoods;
use LWJ\Commodity\Goods\Criteria\ProductMultiWhere;

class SkuController extends Controller
{
    public function index(Request $request)
    {
        //获取搜索项
        $rules = [
            'limit' => 'required|integer',
            'page'  => 'required|integer',
            'sort'  => 'required|string',
            'order' => 'required|string',
        ];

        $params = $request->route()->parameters();
        $errors = $this->validateField($params, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }
        //将page合并到request
        $request->merge(['page' => $params['page']]);
        $search = $request->all();

        $data = Commodity::search()->sku()
            ->pushCriteria(new ProductGoods())
            ->pushCriteria(new ProductMultiWhere($search))
            ->paginate($params['limit']);

        //处理分类
        $cate = Cate::search()->all();
        foreach ($cate as $item) {
            foreach ($data as $datum) {
                if ($datum->cate_id == $item->id) {
                    $datum->cate_name = $item->name;
                }
            }
        }

        return $this->paginate($data);
    }

    /**
     * 更改价格
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePrice(Request $request)
    {
        //验证
        $rules = [
            'id'    => 'required|integer',
            'price' => 'required|numeric',
        ];

        $params = $request->route()->parameters();
        $errors = $this->validateField($params, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Commodity::sku()->update($params['id'], ['price' => $params['price']]);
            $goods = Commodity::search()->findSpuBySku($params['id']);
            event(new GoodsEvent($goods->id), 'update');
            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
    }

    /**
     * 更改库存
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStock(Request $request)
    {
        //验证
        $rules = [
            'id'    => 'required|integer',
            'stock' => 'required|numeric',
        ];

        $params = $request->route()->parameters();
        $errors = $this->validateField($params, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Commodity::sku()->update($params['id'], ['stock' => $params['stock']]);
            $goods = Commodity::search()->findSpuBySku($params['id']);
            event(new GoodsEvent($goods->id), 'update');
            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
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
    public function up(Request $request)
    {
        //验证
        $rules = [
            'id' => 'required|integer',
        ];

        $params = $request->route()->parameters();
        $errors = $this->validateField($params, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }
        
        try {
            Commodity::sku()->up($params['id']);
            $goods = Commodity::search()->findSpuBySku($params['id']);
            event(new GoodsEvent($goods->id), 'update');
            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiUp(Request $request)
    {
        $ids = $request->input('ids');

        foreach ($ids as $id) {
            Commodity::sku()->up($id);
            $goods = Commodity::search()->findSpuBySku($id);
            event(new GoodsEvent($goods->id), 'update');
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
    public function down(Request $request)
    {
        //验证
        $rules = [
            'id' => 'required|integer',
        ];

        $params = $request->route()->parameters();
        $errors = $this->validateField($params, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Commodity::sku()->down($params['id']);
            $goods = Commodity::search()->findSpuBySku($params['id']);
            event(new GoodsEvent($goods->id), 'update');
            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiDown(Request $request)
    {
        $ids = $request->input('ids');

        foreach ($ids as $id) {
            Commodity::sku()->down($id);
            $goods = Commodity::search()->findSpuBySku($id);
            event(new GoodsEvent($goods->id), 'update');
        }

        return $this->success();
    }
}