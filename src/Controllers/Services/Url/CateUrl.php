<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/18
 * Time: 下午6:08
 */

namespace  LWJ\Commodity\Controllers\Services\Url;


class CateUrl implements UrlInterface
{
    private $data;

    private $other;

    /**
     * @return array
     */
    public function handle()
    {
        // 处理url
        foreach ($this->data as &$datum) {
            $datum['url'] = route('web.commodity.goods.search',
                ['cateId' => $datum['id'], 'brandId' => $this->other['brandId'], 'search' => $this->other['search']]);
            if (empty($datum['children'])) {
                continue;
            }
            foreach (($datum['children']) as &$item) {
                $item['url'] = route('web.commodity.goods.search', [
                    'cateId'  => $item['id'],
                    'brandId' => $this->other['brandId'],
                    'search'  => $this->other['search']
                ]);
            }
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