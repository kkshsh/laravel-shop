<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/18
 * Time: 下午8:02
 */

namespace  SimpleShop\Commodity\Controllers\Services\Url;


class BrandUrl implements UrlInterface
{
    private $data;

    private $other;

    /**
     * @return array
     */
    public function handle()
    {
        foreach ($this->data as $datum) {
            $datum['url'] = route('web.commodity.goods.search',
                ['cateId' => $this->other['cateId'], 'brandId' => $datum['brand_id'], 'search' => $this->other['search']]);
        }

        return $this->data;
    }

    /**
     * @param array $data
     * @param array $other
     * @return $this
     */
    public function setData(array $data, array $other)
    {
        $this->data = $data;
        $this->other = $other;

        return $this;
    }
}