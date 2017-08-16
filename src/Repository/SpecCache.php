<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/9
 * Time: 18:31
 */
namespace  Commodity\Repository;


trait SpecCache {


    public function updateCache($specId,$specModel,$specValueModel) {
        $data = $specValueModel->select('name')->where('spec_id',$specId)->pluck('name');
        $re = '';
        if($data) {
            $re = implode(',',$data->toArray());
            $obj = $specModel->find($specId);

            if($obj) {
                $obj->update(['value'=>$re]);
            }
        }
        return true;
    }

}