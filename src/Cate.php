<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace  SimpleShop\Commodity;
use SimpleShop\Commodity\Cate\Brand;
use SimpleShop\Commodity\Cate\Info;
use SimpleShop\Commodity\Cate\Eloquent\CateRepository;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Cate
{
    /**
     * 分类控制
     *
     * @return Info
     */
    public static function info(){
        return app(Info::class);
    }

    /**
     * 品牌控制
     *
     * @return Brand
     */
    public static function brand() {
        return app(Brand::class);
    }

    /**
     * @return CateRepository
     */
    public static function search() {
        return app(CateRepository::class);
    }
}
