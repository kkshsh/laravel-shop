<?php

namespace  LWJ\Commodity\Controllers\Requests;


use App\Http\Requests\Request;

class StoreRequest extends Request
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
            'data'             => 'required|array',
            'spec'             => 'required|array',
            'attr'             => 'required|array',
            'data.cate_id'     => 'required|integer',
            'data.store_id'    => 'required|integer',
            'data.begin_num'   => 'required|integer',
            'data.name'        => 'required|string',
            'data.description' => 'required|string',
            'data.content'     => 'required|string',
            'data.unit'        => 'required|string',
            'data.cover_path'  => 'required|string',
            'data.imgs'        => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'data.cate_id.required'     => '分类必须选择',
            'data.store_id.required'    => '店铺必须选择',
            'data.begin_num.required'   => '起订量必须填写',
            'data.name.required'        => '商品名必须填写',
            'data.description.required' => '详情必须填写',
            'data.content.required'     => '内容必须填写',
            'data.unit.required'        => '单位必须填写',
            'data.cover_path.required'  => '封面图必须设置',
            'data.imgs.required'        => '商品主图必须设置',
            'spec.required'             => '销售属性是必须填写的,请检查是否没有为该分类设定基本属性',
            'attr.required'             => '基本属性是必须填写的,请检查是否没有为该分类设定基本属性',
        ];
    }
}
