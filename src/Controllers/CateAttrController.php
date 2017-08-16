<?php
/**
 * Created by PhpStorm.
 * User: coffee
 * Date: 17-1-19
 * Time: 上午9:34
 */

namespace  LWJ\Commodity\Controllers;


use LWJ\Commodity\Controllers\Requests\AttrSelectRequest;
use Illuminate\Http\Request;
use LWJ\Commodity\Attribute;
use DB;

class CateAttrController extends Controller
{
    public function add(Request $request)
    {
        $rules = [
            'name'    => 'required|string',
            'value'   => 'sometimes|string',
            'type'    => 'required|integer',
            'cate_id' => 'required|integer',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        /*保存attr*/
        $attr = Attribute::info()->add(
            [
                'name'    => $request->input('name'),
                'cate_id' => $request->input('cate_id'),
                'type'    => $request->input('type'),
                'sort'    => $request->input('sort', 1),
                'show'    => $request->input('show', 1),
            ]);

        //如果有value要处理value
        if ($request->input('type') == 2 && $request->input('value') != "") {
            Attribute::value()->add(['attr_id' => $attr->id, 'name' => $request->input('value'), 'sort' => 1]);
        }

        return $this->success();
    }

    /**
     * 获取cate的attr
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cateAttr($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        //获取Attr
        $reData = Attribute::info()->getByCate($id);

        return $this->success($reData);
    }

    /**
     * 删除select属性
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeSelect($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        //删除selectAttr
        try {
            Attribute::info()->delete($id);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
    }

    /**
     * 删除select属性值
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeSelectValue($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }
        //删除selectAttrValue
        try {
            Attribute::value()->delete($id);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
    }

    /**
     * 增加一个select的属性
     *
     * @author jiangzhiheng
     *
     * @param AttrSelectRequest|Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addSelect(AttrSelectRequest $request)
    {
        $data = $request->all();

        //首先先保存
        try {
            $name = $data['name'];
            $value = $data['value'];

            DB::transaction(
                function () use ($name, $value) {
                    if (empty($name['id'])) {
                        $attr = Attribute::info()->add($name);
                        $id = $attr->id;
                    } else {
                        $id = $name['id'];
                        Attribute::info()->updateName($id, $name['name']);
                    }

                    Attribute::value()->updates($id, $value);
                });

            return $this->success();

        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    /**
     * 保存文本属性
     *
     * @author jiangzhiheng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addText(Request $request)
    {
        $rules = [
            'name'    => 'required|string',
            'cate_id' => 'required|integer',
        ];

        $errors = $this->validateField($request->all(), $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }
        $data = $request->only(['cate_id', 'name']);
        $data['type'] = 1;

        try {
            Attribute::info()->add($data);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }

    }

    /**
     * 移除text属性
     *
     * @author jiangzhiheng
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeText($id)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $errors = $this->validateField(['id' => $id], $rules);

        if ( ! empty($errors)) {
            return $this->fail($errors);
        }

        try {
            Attribute::info()->delete($id);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
    }
}