<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/3/31
 * Time: 下午3:25
 */

namespace  LWJ\Commodity\Controllers\Services\SpuListHandler;


use App\Exceptions\NotInstanceofException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class SpuHandle
{
    /**
     * @var array
     */
    private $handler = [];

    /**
     * @var LengthAwarePaginator|Collection|Paginator
     */
    private $paginator;

    /**
     * SpuHandle constructor.
     * @param LengthAwarePaginator|Collection|Paginator $list
     * @param array $handler
     */
    public function __construct($list, array $handler)
    {
        $this->paginator = $list;
        $this->handler = $handler;
    }

    /**
     * 调用apply对数据进行处理
     *
     * @return LengthAwarePaginator|Collection|Paginator
     */
    public function handle()
    {
        foreach ($this->handler as $item) {
            $this->paginator = $item->apply($this->paginator);
        }

        return $this->paginator;
    }

    /**
     * 实例化本类
     * @param LengthAwarePaginator|Collection|Paginator $list
     * @param array $handler
     * @return LengthAwarePaginator|Collection|Paginator
     */
    public static function make($list, array $handler = [])
    {
        if (! $list instanceof LengthAwarePaginator && ! $list instanceof Collection) {
            throw new NotInstanceofException('参数$list不是LengthAwarePaginator或Collection');
        }

        return (new static($list, $handler))->handle();
    }
}