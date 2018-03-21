@if($detail->goodsInfo->store_id != 0)
    <div class="stock_l_cent stock_l_div01">
        <p class="stock_bt"><i class="iconfont icon-dianpu"></i>{{ $detail->goodsInfo->storeInfo->store_name }}</p>
        <div class="text">
            联系人：{{ $store->company_linkman or '暂无' }}<br>
            联系电话：{{ $store->company_phone or '暂无' }} <br>
            所在地区：{{ $store->company_address or '暂无' }} <br>
            <p class="stock_bt2 "><i class="iconfont icon-yanzhengma"></i>认证商家平台担保</p>
        </div>
        <div class="but">
            <a href="javascript:" ui-meiqia class="btn btn-outpri btn-block">在线咨询</a>
            <a href="{{ route('web.shop.index', ['id' => $data['base']->store_id]) }}"
               class="btn btn-outpri btn-block">进入店铺</a>
        </div>
    </div>
@endif