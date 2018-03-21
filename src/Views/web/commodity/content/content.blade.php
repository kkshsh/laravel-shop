@php
    if (empty($detail)) {
        $product = App::make(\SimpleShop\Commodity\Sku::class);
        $detail = $product->find($id);
    }
@endphp

<div class="imglist">
    {!! $detail->goodsInfo->content !!}
</div>