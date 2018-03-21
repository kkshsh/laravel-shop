<?php
/**
 * 处理商家编辑的缓存数据
 */
namespace SimpleShop\Commodity\Listeners;

use SimpleShop\Commodity\Commodity;
use SimpleShop\Commons\Exceptions\DatabaseException;
use SimpleShop\Store\Events\ShopStoreEvent;

class ShopStoreListener
{
    /**
     * @var Commodity
     */
    private $_commodityService;

    /**
     * ShopStoreListener constructor.
     * @param Commodity $commodityService
     */
    public function __construct(Commodity $commodityService)
    {
        $this->_commodityService = $commodityService;
    }

    /**
     * Handle the event.
     *
     * @param  ShopStoreEvent $event
     * @return void
     */
    public function handle(ShopStoreEvent $event)
    {
        switch ($event->action) {
            case "updated" :
                break;
            case "destroyed" :
                if($this->_commodityService->isHasStore($event->storeId)) {
                    //抛出异常
                    throw new DatabaseException("店铺已被使用，删除失败");
                }
                break;
        }
    }

}
