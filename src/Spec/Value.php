<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/6
 * Time: 10:33
 */
namespace Commodity\Spec;

use Illuminate\Database\Eloquent\Model;
use Commodity\Repository\SpecValueRepository;

class Value
{


    protected $specValueRepository;

    public function __construct(SpecValueRepository $specValueRepository)
    {
        $this->specValueRepository = $specValueRepository;

    }

    /**
     * @param $data
     *         name
     *         cate_id
     *         show   1 ? 0
     *         sort
     *
     * @return Model
     */
    public function add($data)
    {
        $ok = $this->specValueRepository->add($data['spec_id'], $data['name'], $data['sort']);

        return $ok;
    }

    /**
     * @param int $spec_id
     * @param array $data [[id=>1,name=>'1111'],[name=>'3333']]
     *
     * @return bool
     * @internal param $attr_id
     */
    public function updates(int $spec_id, array $data)
    {
        $countData = count($data);
        foreach ($data as $key => $val) {
            $addData['spec_id'] = $spec_id;
            $addData['name'] = $val['name'];
            $addData['sort'] = $countData - $key;
            if (isset($val['id']) && $val['id']) {
                $this->specValueRepository->update($val['id'], $addData);
            } else {
                $this->add($addData);
            }

        }

        return true;

    }

    /**
     * 修改名称
     */
    public function updateName($id, $name)
    {
        $ok = $this->specValueRepository->update($id, ['name' => $name]);

        return $ok;
    }

    public function find($id)
    {
        $ok = $this->specValueRepository->find($id);

        return $ok;
    }

    /**
     * 删除分类
     *
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $ok = $this->specValueRepository->delete($id);

        return $ok;
    }
}