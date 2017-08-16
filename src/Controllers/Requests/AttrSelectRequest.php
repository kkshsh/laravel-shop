<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/20
 * Time: 下午4:18
 */

namespace  Commodity\Controllers\Requests;


use Illuminate\Validation\Rule;

class AttrSelectRequest extends Request
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
            'name'         => 'required|array',
            'value'        => 'required|array',
            'name.cate_id' => 'required|integer',
            'name.name'    => [
                'required',
                'string',
                Rule::unique('shop_attribute', 'name')->ignore($this->input('name.id', 'id'))->where(function ($query) {
                    $query->where('type', 2)->where('cate_id', $this->input('name.cate_id'));
                })
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => '名字必须填写',
            'value.required'   => '排序必须填写',
            'name.name.unique' => '属性名称不能重复',
        ];
    }
}