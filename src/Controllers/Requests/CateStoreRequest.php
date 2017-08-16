<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/20
 * Time: 下午3:33
 */

namespace  LWJ\Commodity\Controllers\Requests;


use App\Http\Requests\Request;

class CateStoreRequest extends Request
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
            'name'     => 'required|string',
            'pid'      => 'sometimes|integer',
            'sort'     => 'required|integer',
            'cate_dir' => 'required|string|unique:shop_category,cate_dir',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => '名字必须选择',
            'sort.required'     => '排序必须填写',
            'cate_dir.required' => '分类目录必须填写',
            'cate_dir.unique'   => '分类目录不能和其他分类的重复'
        ];
    }
}