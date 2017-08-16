<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace  LWJ\Commodity;
use LWJ\Commodity\Attribute\Info;
use LWJ\Commodity\Attribute\Value;


/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Attribute
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
