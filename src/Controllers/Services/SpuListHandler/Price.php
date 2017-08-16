<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/3/31
 * Time: 下午3:49
 */

namespace  LWJ\Commodity\Controllers\Services\SpuListHandler;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class Price implements SpuListHandleInterface
{
    /**
     * 处理方法
     *
     * @param LengthAwarePaginator|Collection|Paginator $list
     * @return LengthAwarePaginator|Collection|Paginator
     */
    public function apply($list)
    {
        return $list;
    }
}