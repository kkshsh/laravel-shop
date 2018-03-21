@php
    if (empty($detail)) {
        $product = App::make(\SimpleShop\Commodity\Sku::class);
        $detail = $product->find($id);
    }
@endphp

<div class="fl">
                <i></i>
                <a href="{{ route('web.index') }}">首页</a><span>&gt;</span>
                <a href="{{ route('web.commodity.goods.index') }}">商品</a><span>&gt;</span>
                <a href="{{ route('web.commodity.goods.cate', ['type' => 's', 'cate_id' => $detail->goodsInfo->cateInfo->pid]) }}"
                   class="detail">{{ $detail->goodsInfo->cateInfo->name or '分类' }}</a>
</div>