<?php

namespace  SimpleShop\Commodity\Controllers\Requests;

use App\Exceptions\ValidatorErrorException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

abstract class Request extends FormRequest
{
    /**
     * @param Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        if (request()->ajax() || request()->wantsJson() || request()->isJson()) {
            throw new ValidatorErrorException($validator->getMessageBag()->all());
        }

        return parent::formatErrors($validator);
    }

    /**
     * 获取所有的输入项
     *
     * @return array
     */
    public function getAll()
    {
        return $this->all();
    }
}
