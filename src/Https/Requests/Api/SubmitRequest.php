<?php

namespace SimpleShop\Commodity\Https\Requests\Api;


use SimpleShop\Commons\Requests\Request;

class SubmitRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cate_id'         => 'required|integer',
            'name'        => 'required|string|between:1,50',
//            'brand_id'         => 'required|integer',
            'unit_id'         => 'required|integer',
            'spec'         => 'required|array',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cate_id.required'    => '必须选择商品分类',
            'name.required'   => '商品名称必须填写',
            'brand_id.required'    => '必须选择商品品牌',
            'unit_id.required'    => '必须选择商品单位',
            'name.between'    => '分类名字字数在1-50之间',
            'spec.array' => '请传入正确的SKU数据',
        ];
    }
}
