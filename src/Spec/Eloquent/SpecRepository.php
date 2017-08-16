<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace SimpleShop\Commodity\Goods\Eloquent;


use SimpleShop\Commodity\Repository\Repository;

class SpecRepository extends Repository {

    public function model() {
        return 'SimpleShop\Commodity\Models\ShopSpecModel';
    }

}