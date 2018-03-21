@php
    if (empty($detail)) {
        $product = App::make(\SimpleShop\Commodity\Sku::class);
        $detail = $product->find($id);
        $skuList = $product->getSkuListByGoodsId($detail->goods_id);
    }
@endphp

<div class="divfr fr">
    <h1 class="finbt"><div id="choose_sku_name">{{ $detail->name }}</div><span>
                            {{ $detail->goodsInfo->storeInfo->store_name }}</span></h1>
    <p class="introduce">{{ $detail->goodsInfo->description }}</p>
    <ul class="ullit">
        <li class="price">
            <p>
                <span class="textfl">商城价：</span>
                <span class="pfl price price-change">￥{{ $detail->price }} </span><span>元/{{ $detail->goodsInfo->units->name or '件' }}</span>
                &nbsp;&nbsp;
                {{--<span class="col999" id="sold">（已售件）</span>--}}
            </p>
            <div class="ov_h"></div>
        </li>
        <li>
            <span class="textfl2">品牌：{{ $detail->goodsInfo->brandInfo->name or '暂无品牌' }}</span>
        </li>
        <li>
            <span class="textfl2">起订量：{{ $detail->goodsInfo->begin_num }}{{ $detail->goodsInfo->units->name or '件' }} 起</span>
        </li>
    </ul>
    <ul class="attrlit" id="spec_list">
        <input type="hidden" value="{{ $skuList->toJson() }}" id="sku_json">
        <input type="hidden" value="{{ $detail['id'] }}" id="sku_id">
        <input type="hidden" value="{{ $detail['name'] }}" id="sku_name">
        <input type="hidden" value="{{ $detail['price'] }}" id="sku_price">
        <input type="hidden" value="{{ $detail['spec'] }}" id="choose_sku_spec">
        <input type="hidden" value="{{ $detail->goodsInfo->id }}" id="spu_id">
        <?php $skuArray = json_decode($detail['spec'], true)?>
        {{--销售属性--}}
        @foreach($detail->goodsInfo->spec as $index => $item)
            <li>
                <span class="fl textfl">{{ $index }}：</span>
                <div class="fl">
                    @foreach($item as $value)
                        <label data-spec-id="{{ $value['spec_value_id'] }}"
                               @if(in_array($value['spec_value_id'], $skuArray)) class="fin_attr_active fin"
                               @else class="fin_attr fin" @endif>{{ $value['spec_value_name'] }}<input
                                    type="checkbox"
                                    value="" name=""/><em
                                    class="icon"></em></label>
                    @endforeach
                </div>
                <div class="ov_h"></div>
            </li>
        @endforeach
        <li>
            <span class="fl textfl">数量：</span>
            <div class="fl">
                <div class="icon_cal" min="{{ $detail->goodsInfo->begin_num or 0 }}"
                     max="{{ $detail['stock'] }}" id="num">
                    <a href="javascript:" class="change-num">-</a>
                    <input id="buy_num" type="text" value="1"/>
                    <a href="javascript:" class="change-num">+</a>
                </div>
            </div>
            <div class="ov_h"></div>
        </li>
    </ul>
    <div class="tab_but" id="button_area">
        @if($detail['status'] == 0)
            <a href="javascript:" class="btn btn-default btn-max"><i class="iconfont icon-gouwuche"></i>已下架</a>
        @elseif($detail['stock'] < $detail->goodsInfo->begin_num)
            <a href="javascript:" class="btn btn-default btn-max"><i class="iconfont icon-gouwuche"></i>已售罄</a>
        @else
            {{--<a href="{{ route('web.order.buyNow', ['id' => $detail['id'], 'num' => $detail->goodsInfo->begin_num]) }}"--}}
               {{--class="btn btn-primary btn-max" id="buy_now">立即购买</a>--}}
            <a href="javascript:"
               class="btn btn-primary btn-max" id="buy_now">立即购买</a>
            <a href="javascript:" class="btn btn-default btn-max" id="add_cart"><i
                        class="iconfont icon-gouwuche"></i>加入购物车</a>
        @endif
    </div>
</div>