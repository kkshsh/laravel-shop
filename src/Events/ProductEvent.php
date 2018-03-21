<?php


namespace SimpleShop\Commodity\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProductEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $skuId;

    /**
     * @var string
     */
    public $action = 'delete';

    /**
     * Create a new event instance.
     *
     * @param int $goodsId
     * @param string $action
     */
    public function __construct(int $skuId, string $action = 'delete')
    {
        //
        $this->skuId = $skuId;
        $this->action = $action;
    }
}
