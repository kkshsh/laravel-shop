<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/10
 * Time: 16:58
 */
namespace  Commodity\Goods\Check;

trait FilterData {

    public function infoData($data){
        $data['name'] = trim($data['name']);
        return $data;
    }
}