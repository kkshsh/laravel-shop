<?php


namespace SimpleShop\Commodity\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class GoodsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $goodsId;

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
    public function __construct(int $goodsId, string $action = 'delete')
    {
        //
        $this->goodsId = $goodsId;
        $this->action = $action;
    }
}
