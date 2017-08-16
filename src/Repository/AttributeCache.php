<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/9
 * Time: 18:31
 */

namespace Commodity\Repository;


trait AttributeCache
{
    /**
     * @param $attrId
     * @param $attributeModel
     * @param $attributeValueModel
     * @return bool
     */
    public function updateCache($attrId, $attributeModel, $attributeValueModel)
    {
        $data = $attributeValueModel->select('name')->where('attr_id', $attrId)->pluck('name');
        $re = '';
        if ($data) {
            $re = implode(',', $data->toArray());
            $obj = $attributeModel->find($attrId);
            if ($obj) {
                $obj->update(['attr_value' => $re]);
            }
        }
        return true;
    }

}