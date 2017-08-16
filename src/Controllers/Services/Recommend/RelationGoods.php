<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/3/17
 * Time: 下午5:10
 */

namespace  SimpleShop\Commodity\Controllers\Services\Recommend;


use Illuminate\Support\Collection;
use SimpleShop\Commodity\Commodity;

class RelationGoods implements GoodsRecommendInterface
{
    /**
     * @var int 商品id
     */
    private $goodsId;

    /**
     * @var array 可选参数
     */
    private $option;

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
     *
     * @return Collection
     */
    public function getData(): Collection
    {
        //有一个设定的默认值
        $limit = $this->option['limit'] ?? config('commodity.goods.recommend.limit', 5);
        $data = Commodity::search()->goodsCommend($this->goodsId, $limit);

        if (! $data instanceof Collection) {
            return collect($data);
        }

        /** @var Collection $data */
        return $data;
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