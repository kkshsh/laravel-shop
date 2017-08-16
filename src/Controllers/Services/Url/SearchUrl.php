<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/18
 * Time: 下午8:06
 */

namespace  Commodity\Controllers\Services\Url;


class SearchUrl implements UrlInterface
{
    private $data;

    private $other;

    /**
     * @return array
     */
    public function handle()
    {
        foreach ($this->data as &$datum) {
            foreach ($datum as &$item) {
                $str = $this->searchHandle($item['name']);

                $item['url'] = route('web.commodity.goods.search', ['cateId' => $this->other['cateId'], 'brandId' => $this->other['brandId'], 'search' => $str]);
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

    protected function searchHandle($input)
    {
        $search = $this->other['search'];

        if ($search == '') {
            return $input;
        }

        $array = explode('-', $search);

        if (in_array($input, $array, true)) {
            return $search;
        }

        return $search . '-' . $input;
    }
}