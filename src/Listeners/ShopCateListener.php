<?php
/**
 * 处理商品分类编辑的缓存数据
 */

namespace SimpleShop\Commodity\Listeners;

use SimpleShop\Commodity\Commodity;
use SimpleShop\Cate\Events\ShopCateEvent;
use SimpleShop\Commons\Exceptions\DatabaseException;

class ShopCateListener
{
    /**
     * @var Commodity
     */
    private $_commodityService;

    /**
     * ShopCateListener constructor.
     * @param Commodity $commodityService
     */
    public function __construct(Commodity $commodityService)
    {
        $this->_commodityService = $commodityService;
    }

    /**
     * Handle the event.
     *
     * @param  ShopCateEvent $event
     * @return void
     */
    public function handle(ShopCateEvent $event)
    {
        //创建搜索添加
        switch ($event->action) {
            case "updated" :

                break;
            case "destroyed" :
                if($this->_commodityService->isHasCate($event->cateId)) {
                    //抛出异常
                    throw new DatabaseException("分类已被使用，删除失败");
                }
                break;
        }
    }

}
