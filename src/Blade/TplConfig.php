<?php
/**
 * Created by PhpStorm.
 * User: dd
 * Date: 2018/3/12
 * Time: 17:39
 */

namespace SimpleShop\Commodity\Blade;

class TplConfig
{

    /**
     * @param $id
     *
     * @return string
     */
    public static function get($tpl,$key)
    {
        // todo 这里getConfig()传变量不行，传字符串可以
        //var_dump($tpl,$key,22222,app(\SimpleShop\Commons\TplConfig::class)->getConfig("{$tpl}", "{$key}"));exit;
        return app(\SimpleShop\Commons\TplConfig::class)->getConfig($tpl, $key);
    }
}