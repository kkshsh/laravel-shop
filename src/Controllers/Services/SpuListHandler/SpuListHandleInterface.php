<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/3/31
 * Time: 下午3:22
 */

namespace  SimpleShop\Commodity\Controllers\Services\SpuListHandler;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface SpuListHandleInterface
{
    /**
     * 处理方法
     *
     * @param LengthAwarePaginator|Collection|Paginator $list
     * @return LengthAwarePaginator|Collection|Paginator
     */
    public function apply($list);
}