<?php

namespace  Commodity\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAddOrUpdateRequest extends FormRequest
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
            'id'      => 'sometimes|integer',
            'cate_id' => 'required|integer',
            'name'    => 'required|string',
            'value'   => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'cate_id.required' => '分类id必须有',
            'name.required'    => '属性项必须有',
            'value.required'   => '属性值必须有',
        ];
    }
}
