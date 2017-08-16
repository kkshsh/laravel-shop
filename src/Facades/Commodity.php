<?php

/*
 * This file is part of Commidity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the Commodity facade class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Commodity extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'commodity';
    }
}
