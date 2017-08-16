<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/6
 * Time: 10:33
 */
namespace  LWJ\Commodity\Attribute;

use LWJ\Commodity\Repository\AttributeValueRepository;

class Value  {


    protected $attributeValueRepository;

    public function __construct(AttributeValueRepository $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;

    }

    /**
     * @param $data
     *         name
     *         cate_id
     *         show   1 ? 0
     *         sort
     *
     */
    public function add($data) {
        $ok = $this->attributeValueRepository->add($data['attr_id'],$data['name'],$data['sort']);
        return  $ok;
    }

    /**
     * @author jiangzhiheng
     *
     * @param $names
     * @param array $data ['值1','值2']
     *
     * @return bool
     */
    public function addNames($attr_id,$names) {
        $countData = count($names);
        foreach ($names as $key=>$name) {
            $val['attr_id'] = $attr_id;
            $val['name'] = $name;
            $val['sort'] = $countData - $key;
            $ok = $this->add($val);
        }
        return true;

    }

    /**
     * @param $attr_id
     * @param $data [[id=>1,name=>'1111'],[name=>'3333']]
     *
     * @return bool
     * @throws \Exception
     */
    public function updates($attr_id, $data) {
        $countData = count($data);
        foreach ($data as $key=>$val) {
            $addData['attr_id'] = $attr_id;
            $addData['name'] = $val['name'];
            $addData['sort'] = $countData - $key;
            if(isset($val['id']) && $val['id']) {
                $this->attributeValueRepository->update($val['id'],$addData);
            }else{
                $this->add($addData);
            }
        }
        return true;

    }

    /**
     * 修改名称
     *
     * @param $id
     * @param $name
     *
     * @return bool
     */
    public function updateName($id, $name) {
        $ok =  $this->attributeValueRepository->update($id,['name'=>$name]);
        return $ok;
    }

    /**
     * 删除分类
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id){
        $ok =  $this->attributeValueRepository->delete($id);
        return $ok;
    }


}