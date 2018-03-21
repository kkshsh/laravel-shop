@php
    /** @var \SimpleShop\Commodity\Sku $product */
    $product = App::make(\SimpleShop\Commodity\Sku::class);
    $detail = $product->find($id);
    $skuList = $product->getSkuListByGoodsId($detail->goods_id);
    $pics = $detail->pics;
    /** @var \SimpleShop\Commodity\Spec $spec */
    $spec = App::make(\SimpleShop\Commodity\Spec::class);
    $detail->goodsInfo->spec = $spec->groupGoodsItem($detail->goods_id);
    /** @var \SimpleShop\Commodity\Attr $attr */
    $attr = App::make(\SimpleShop\Commodity\Attr::class);
    $detail->goodsInfo->attr = $attr->groupGoodsItem($detail->goods_id);
@endphp

@extends('Goods::web.layout')

{{--引入内容组件--}}
@section('content')


@endsection