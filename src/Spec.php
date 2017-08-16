<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace  SimpleShop\Commodity;
use SimpleShop\Commodity\Spec\Info;
use SimpleShop\Commodity\Spec\Value;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Spec
{

    /**
     * 品牌基本管理
     * @return \Illuminate\Foundation\Application|mixed
     *
     */
    static function info() {
        return app(Info::class);
    }

    static function value() {
        return app(Value::class);
    }


}
