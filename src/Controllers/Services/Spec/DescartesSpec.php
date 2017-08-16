<?php
/**
 * Created by PhpStorm.
 * User: j5110
 * Date: 2017/3/16
 * Time: 21:29
 */

namespace  LWJ\Commodity\Controllers\Services\Spec;

use LWJ\Commodity\Commodity;

class DescartesSpec implements SpecToSkuInterface
{
    /**
     * 将spec数组更改为一个记录了spec层次的二维数组
     *
     * @param array $input
     * $specArray为
     *  0 => array:4 [▼
     * "spec_id" => 2
     * "spec_name" => "规格"
     * "spec_value_id" => 10
     * "spec_value_name" => "1.5米单床"
     * ]
     * 1 => array:4 [▼
     * "spec_id" => 4
     * "spec_name" => "尺寸"
     * "spec_value_id" => 13
     * "spec_value_name" => "11M"
     * ]
     * 2 => array:4 [▼
     * "spec_id" => 5
     * "spec_name" => "内存"
     * "spec_value_id" => 16
     * "spec_value_name" => "1G"
     * ]
     * @return array
     */
    public function handler(array $input): array
    {

        //  二维数组去重处理
        $unique = $this->duplicateRemoval($input);

        //  获取笛卡儿积

        return $this->getDescartes(array_values($unique));
    }

    /**
     * 为进来的数据去重
     *
     * @param array $input
     * @return array
     */
    protected function duplicateRemoval(array $input): array
    {
        $output = [];
        foreach ($input as $item) {
            if (empty($output[$item['spec_id']]) || (! empty($output[$item['spec_id']]) && array_search($item['spec_value_id'],
                        $output[$item['spec_id']]) === false)
            ) {
                $output[$item['spec_id']][] = $item['spec_value_id'];
            }
        }

        return $output;
    }

    /**
     * 获取笛卡儿积
     *
     * @param array $input
     * @return array
     */
    protected function getDescartes(array $input): array
    {

        if (count($input) == 1) {
            return array_chunk($input[0], 1);
        }

        $temp = array_shift($input); //弹出第一个

        if (! is_array($temp)) {
            $temp = (array)$temp;
        }

        $temp = array_chunk($temp, 1);

        do {
            $output = [];
            $tmp = array_shift($input); //弹出接下来的第二个，直到把最外层的数组都弹出来

            if (! is_array($tmp)) {
                $tmp = (array)$tmp;
            }

            foreach ($temp as $item) {
                foreach (array_chunk($tmp, 1) as $value) {
                    $output[] = array_merge($item, $value);
                }
            }
            $temp = $output;
        } while ($input);

        return $output;
    }

    /**
     * @param int $id 商品id
     * @param array $input 笛卡儿积的数组
     * @return array
     */
    protected function getData(int $id, array $input)
    {
        $output = [];
        //循环从数据库中查询出对象
        foreach ($input as $item) {
            $output[] = Commodity::getSKU($id, $item)->toArray();
        }

        return $output;
    }
}