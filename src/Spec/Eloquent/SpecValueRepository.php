<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace Commodity\Spec\Eloquent;

use Commodity\Repository\Repository;


class SpecValueRepository extends Repository {

    public function model() {
        return 'Commodity\Models\ShopSpecValueModel';
    }

    /**
     *
     * @param $specVale获取属性名称
     *
     */
    public function getSpecNameByValueIds($idValues) {
        $obj = $this->model->whereIn('id',$idValues)->get();
        $specName = '';
        foreach($obj as $val) {
            $specName .= $val->name . ",";
        }
        if($specName) {
            $specName = substr($specName,0,-1);
        }
        return $specName;
    }
}