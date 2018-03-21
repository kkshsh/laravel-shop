@php
    if (empty($detail)) {
        $product = App::make(\SimpleShop\Commodity\Sku::class);
        $detail = $product->find($id);
    }
@endphp

<div class="stock_bt">
    <a href="" class="active">商品参数</a>
</div>
<dl class="dllit">
    <dt>产品参数：</dt>
    <?php $valueName = '';?>
    @foreach($detail->goodsInfo->attr as $key => $item)
        @foreach($item as $value)
            @php
                $valueName .= $value['attr_value_name'];
            @endphp
        @endforeach
        <dd>{{ $key }}: {{ $valueName }}</dd>
    @endforeach

    <div class="ov_h"></div>
</dl>