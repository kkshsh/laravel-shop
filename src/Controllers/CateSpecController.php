<?php
/**
 * Created by PhpStorm.
 * User: wangzd
 * Date: 17-3-9
 * Time: 下午8:31
 */

namespace  LWJ\Commodity\Controllers;


use LWJ\Commodity\Controllers\Traits\ReturnFormat;
use Illuminate\Http\Request;
use LWJ\Commodity\Spec;
use DB;

class CateSpecController extends Controller
{
    use ReturnFormat;

    /**
     * 获取分类下面的销售属性
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cateSpec($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        //获取Attr
        $reData = Spec::info()->getByCate($id);

        return $this->success($reData);
    }

    /**
     * 删除属性
     *
     * @author jiangzhiheng
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeSpec($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Spec::info()->delete($id);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 删除属性值
     *
     * @author jiangzhiheng
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeSpecValue($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Spec::value()->delete($id);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 保存或修改销售属性
     *
     * @author jiangzhiheng
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addSpec(Request $request)
    {
        $rules = [
            'name'  => 'required|array',
            'value' => 'required|array',
        ];

        $data = $request->all();
        $errors = $this->validateField($data, $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            $name = $data['name'];
            $value = $data['value'];

            DB::transaction(
                function () use ($name, $value) {
                    if (empty($name['id'])) {
                        $attr = Spec::info()->add($name);
                        $id = $attr->id;
                    } else {
                        $id = $name['id'];
                        Spec::info()->updateName($id, $name['name']);
                    }

                    Spec::value()->updates($id, $value);
                });

            return $this->success();

        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}