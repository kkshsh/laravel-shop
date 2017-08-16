<?php
/**
 * Created by PhpStorm.
 * User: coffee
 * Date: 17-1-16
 * Time: 上午11:34
 */

namespace  LWJ\Commodity\Controllers;


use LWJ\Commodity\Controllers\Requests\CateStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use LWJ\Commodity\Cate;
use LWJ\Commodity\Cate\Criteria\CatePid;
use LWJ\Commodity\Commodity;

class CateController extends Controller
{
    /**
     * 出首页的数据
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

        $search = $request->route()->parameters();
        $errors = $this->validateField($search, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        //将page合并到request
        $request->merge(['page' => $search['page']]);
        $cates = Cate::search()->orderAll();
//        $cates = generate_str_tree($cates);
        $cates = new LengthAwarePaginator($cates->all(), $cates->count(), 999);

        return $this->paginate($cates);
    }

    /**
     * 保存
     *
     * @author jiangzhiheng
     *
     *
     *
     * @param CateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CateStoreRequest $request)
    {
        $data['data'] = $request->all();
        //处理数据
        try {
            Cate::info()->add($data['data']);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 获取分类详情
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $request->route()->parameter('id')], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        $reData = Cate::search()->find($request->route()->parameter('id'));

        return $this->success($reData);
    }

    /**
     * 获取分类的子分类
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChild(Request $request)
    {
        $id = $request->route('id');
        $reData = Cate::search()->pushCriteria(new CatePid([$id]))->all();

        return $this->success($reData);
    }

    /**
     * 修改一条分类
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'id'        => 'required|integer',
            'data.name' => 'required|string',
            'data.pid'  => 'required|integer',
            'data.sort' => 'required|integer',
        ];

        $requestData['id'] = $request->input('id');
        $requestData['data'] = $request->except(['id']);
        $errors = $this->validateField($requestData, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }
        try {
            Cate::info()->update($requestData['id'], $requestData['data']);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 删除一条记录
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $id = $request->route()->parameter('id');
        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            // 如果有商品已经开始使用该分类,就不能删除,抛出异常
            Commodity::info()->cateIsUsed($id);
            Cate::info()->cateIsUsed($id);
            Cate::info()->delete($id);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}