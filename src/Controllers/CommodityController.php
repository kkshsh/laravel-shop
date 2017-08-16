<?php
/**
 * Created by PhpStorm.
 * User: wangzd
 * Date: 17-1-16
 * Time: 下午3:33
 */

namespace  Commodity\Controllers;


use Commodity\Controllers\Requests\StoreRequest;
use Commodity\Controllers\Services\GoodsService;
use Illuminate\Http\Request;
use Commodity\Commodity;
use Commodity\Goods\Criteria\GoodsMultiWhere;
use DB;
use Commodity\Goods\Criteria\GoodsOrder;

class CommodityController extends Controller
{
    /**
     * 商品列表的首页数据
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
        $search = $request->all();

        if (! empty($errors)) {
            return $this->fail($errors);
        }
        //将page合并到request
        $request->merge(['page' => $params['page']]);
        //调用方法进行搜索
        $reData = Commodity::search()->spu()
            ->pushCriteria(new GoodsMultiWhere($search))
            ->pushCriteria(new GoodsOrder())
            ->paginate($params['limit']);

        return $this->paginate($reData);
    }

    /**
     * 保存商品
     *
     * @author jiangzhiheng
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $data = $request->input('data');

        try {
            Commodity::info()->add($data, $request->input('attr'), $request->input('spec'));

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 修改商品
     *
     * @author jiangzhiheng
     *
     * @param int $id
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, StoreRequest $request)
    {
        $imgs = $request->input('data')['imgs'];
        $data = $request->input('data');
        unset($data['imgs']);
        // 进行各种更新
        DB::transaction(function () use ($id, $request, $data, $imgs) {
            Commodity::info()->update($id, $data);
            Commodity::info()->updateAttr($id, $request->input('attr'));
            Commodity::info()->updateImages($id, $imgs);
            Commodity::info()->updateSpec($id, $request->input('spec'));
        });

        return $this->success();
    }

    /**
     * 商品详情
     *
     * @author jiangzhiheng
     * @param $id
     * @param GoodsService $goodsService
     * @param Store $store
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id, GoodsService $goodsService)
    {
        $rules = [
            'id' => 'required|integer',
        ];
        $errors = $this->validateField(['id' => $id], $rules);

        if (! empty($errors)) {
            return $this->fail($errors);
        }

        $reData = $goodsService->detail($id);

        return $this->success($reData);
    }

    /**
     * 删除一条数据
     *
     * @author jiangzhiheng
     *
     * @param int $id 商品的主键id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];
        $errors = $this->validateField(['id' => $id], $rules);

        if (! empty($errors)) {
            return $this->fail($errors);
        }
        Commodity::info()->delete($id);

        return $this->success();
    }

    /**
     * 获取spec
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpec($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if (! empty($errors)) {
            return $this->fail($errors);
        }

        $result = Commodity::search()->spu()->getSpecId($id);

        return $this->success($result);
    }

    /**
     * 获取attr
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAttr($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if (! empty($errors)) {
            return $this->fail($errors);
        }

        $result = Commodity::search()->spu()->getAttrId($id);

        return $this->success($result);
    }

    /**
     * 上架
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function up($id)
    {
        Commodity::info()->up($id);
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
            Commodity::info()->up($id);
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
        Commodity::info()->down($id);
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
            Commodity::info()->down($id);
        }

        return $this->success();
    }
}