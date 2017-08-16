<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/6
 * Time: 10:33
 */
namespace  LWJ\Commodity\Spec;

use Illuminate\Database\Eloquent\Model;
use LWJ\Commodity\Repository\SpecRepository;
use LWJ\Commodity\Spec\Eloquent\SpecValueRepository;

class Info  {
    /**
     * The Commodity  (aka the issuer).
     *
     * @var LWJ\Commodity;
     */
    protected $specRepository;
    protected $specValueRepository;

    public function __construct(
        SpecRepository $specRepository,
        SpecValueRepository $specValueRepository


    )
    {
        $this->specRepository = $specRepository;
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
    public function add($data) {
       return  $this->specRepository->add($data);
    }

    /**
     * 修改名称
     *
     * @param int $id
     * @param string $name
     *
     * @return bool
     */
    public function updateName(int $id, string $name) {
        return $this->specRepository->update($id, ['name'=>$name]);
    }

    public function getNameByValues($idValues) {
        return $this->specValueRepository->getSpecNameByValueIds($idValues);
    }

    public function getSpecMd5ByValueIds($idValues,$rand=null) {
        sort($idValues);
        return md5(json_encode($idValues) . $rand);
    }

    /**
     *
     * 删除分类
     *
     * @param $id
     *
     * @return bool
     */
    public function delete($id){
        return $this->specRepository->delete($id);
    }

    /**
     * 分类ID
     * @param $cateId
     */
    public function getByCate($cateId) {
        return $this->specRepository->searchCateId($cateId);
    }



}