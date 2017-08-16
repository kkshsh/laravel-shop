<?php
/**
 * Created by PhpStorm.
 * User: wangzd
 * Date: 2017/3/16
 * Time: 上午10:13
 */

namespace  Commodity\Controllers;

use Illuminate\Http\Request;
use Commodity\Attribute;

class AttrController extends Controller
{
    /**
     * 添加或返回一个value
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findOrCreateValue(Request $request)
    {
        $rules = [
            'attr_id' => 'required|integer',
            'value'   => 'required|string'
        ];
        $errors = $this->validateField($request->all(), $rules);

        if (! empty($errors)) {
            return $this->fail($errors);
        }

        //查询一个值
        $reData = Attribute::value()->add(['attr_id' => $request->input('attr_id'), 'name' => $request->input('value'), 'sort' => 1]);

        return $this->success($reData->id);
    }
}