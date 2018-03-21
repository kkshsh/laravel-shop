<?php

namespace SimpleShop\Commodity\Https\Requests\Api;



use SimpleShop\Commons\Utils\Requests\Request;

class ListRequest extends Request
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

        ];
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = $this->route()->parameters();

        if (! isset($params['order'])) {
            $params['order'] = 'id';
        }

        if (! isset($params['sort'])) {
            $params['sort'] = 'desc';
        }

        if (! isset($params['limit'])) {
            $params['limit'] = 20;
        }

        if (! isset($params['page'])) {
            $params['page'] = 1;
        }

        return $params;
    }
}
