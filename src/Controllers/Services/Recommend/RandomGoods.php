<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/3/17
 * Time: 下午4:33
 */

namespace  Commodity\Controllers\Services\Recommend;


use Illuminate\Support\Collection;
use Commodity\Commodity;

class RandomGoods implements GoodsRecommendInterface
{
    /**
     * @var int goodsId
     */
    protected $goodsId;

    /**
     * @var array other params. Is maybe not
     */
    protected $option = [];

    /**
     * 设置参数
     *
     * @param int $goodsId
     * @param array $option
     * @return $this
     */
    public function setData(int $goodsId, array $option = [])
    {
        $this->goodsId = $goodsId;
        $this->option = $option;

        return $this;
    }

    /**
     * 获取数据
     * 随机出limit对应的数据
     *
     * @return Collection
     */
    public function getData(): Collection
    {
        $storeIds = $this->option['store_id'];
        $limit = $this->option['limit'] ?? config('commodity.goods.recommend.limit', 3);

        return Commodity::search()->spu()->getRandom($limit, implode(',', $storeIds));
    }

    /**
     * 设置定时任务
     *
     * @return void
     */
    public function setTimeTask()
    {
        // TODO: Implement setTimeTask() method.
    }
}