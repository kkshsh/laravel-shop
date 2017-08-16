<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace  Commodity\Brand;
use Commodity\Brand\Eloquent\BrandRepository;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Info
{
    /**
     * The Commodity  (aka the issuer).
     *
     * @var Commodity;
     */
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;

    }

    /**
     * 添加分类
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add(array $data) {
        return $this->brandRepository->add($data);
    }


    /**
     * 修改分类
     *
     * @param $id
     * @param $data
     *
     * @return bool
     */
    public function update($id,$data) {
        return $this->brandRepository->update($id,$data);
    }

    /**
     * 删除分类
     */
    public function delete($id){
        return $this->brandRepository->delete($id);
    }



}
