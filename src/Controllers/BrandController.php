<?php
/**
 * Created by PhpStorm.
 * User: wangzd
 * Date: 17-1-18
 * Time: 下午3:00
 */

namespace  Commodity\Controllers;


use Illuminate\Http\Request;
use Commodity\Brand;
use Commodity\Cate;

class BrandController extends Controller
{
    /**
     * 获取所有的品牌分类
     *
     * @author jiangzhiheng
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        $reData = Brand::search()->all();

        return $this->success($reData);
    }

    /**
     * 根据cate获取当前的品牌
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        $reData = Brand::search()->getListByCateId($request->input('id'));

        return $this->success($reData);
    }

    /**
     * 获取除了自身的品牌
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExceptSelf($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        $reData = Brand::search()->getExceptSelf($id);

        return $this->success($reData);
    }

    /**
     * 获取自己已经选择的值
     *
     * @author jiangzhiheng
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSelf($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        $reData = Brand::search()->getSelf($id);

        return $this->success($reData);
    }

    /**
     * 搜索
     *
     * @author jiangzhiheng
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($id, Request $request)
    {
        $rules = [
            'id'   => 'required|integer',
            'name' => 'sometimes|string',
        ];

        $name = $request->route()->parameter('name', '');

        $errors = $this->validateField(['id' => $id, 'name' => $name], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        $reData = Brand::search()->getExceptSelf($id, $name);

        return $this->success($reData);
    }

    /**
     * 添加一个品牌
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'logo' => 'required|string',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            $reData = Brand::info()->add($request->only(['name', 'logo']));

            return $this->success($reData);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 增加多个品牌
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adds(Request $request)
    {
        $rules = [
            'id'        => 'required|integer',
            'brand_ids' => 'required|array',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Cate::brand()->add($request->input('id'), $request->input('brand_ids'));

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 移出
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removes(Request $request)
    {
        $rules = [
            'id'        => 'required|integer',
            'brand_ids' => 'required|array',
        ];
        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Cate::brand()->remove($request->input('id'), $request->input('brand_ids'));

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 移出全部品牌
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAll($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Cate::brand()->removeAll($id);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 删除品牌
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
            'id'        => 'required|integer',
            'brand_ids' => 'required|array',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Cate::brand()->delete($request->input('id'), $request->input('brand_ids'));

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}