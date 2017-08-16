<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/3/17
 * Time: 下午3:54
 */

namespace  LWJ\Commodity\Controllers\Services\Recommend;


use Illuminate\Support\Collection;

interface GoodsRecommendInterface
{
    /**
     * 设置参数
     *
     * @param int $goodsId 需要关联商品的id
     * @param array $option 辅助参数 目前有
     *              limit 取的条数
     * @return $this
     */
    public function setData(int $goodsId, array $option = []);

    /**
     * 获取数据
     *
     * @return Collection
     */
    public function getData(): Collection;

    /**
     * 设置定时任务
     *
     * @return void
     */
    public function setTimeTask();
}