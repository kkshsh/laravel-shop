@php
    if (empty($detail)) {
        $product = App::make(\SimpleShop\Commodity\Sku::class);
        $detail = $product->find($id);
    }
@endphp

<div class="divfl fl">
    <div class="fin_ban" id="fin_ban" ui-switch={addlit:false,time:999999999}>
        <ul class="ullit">
            @foreach($pics as $key => $pic)
                @if($key==0)
                    <li>
                        <img src="{{ $pic->path }}?x-oss-process=image/resize,m_fixed,h_500,w_500"/>
                    </li>
                @else
                    <li style="display: none;">
                        <img src="{{ $pic->path }}?x-oss-process=image/resize,m_fixed,h_500,w_500"/>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="ulodd">
            @foreach($pics as $key => $pic)
                @if($key==0)
                    <a class="compng ayes"><img
                                data-original="{{ $pic->path }}?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                alt="{{ $pic->desc }}"
                                src="{{ $pic->path }}?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                style="display: inline;"></a>
                @else
                    <a class="compng "><img
                                data-original="{{ $pic->path }}?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                alt="{{ $pic->desc }}"
                                src="{{ $pic->path }}?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                style="display: inline;"></a>
                @endif
            @endforeach
        </div>
    </div>
    <div class="text">
        <a href="javascript:" id="favorite"><i class="iconfont icon-guanzhu"></i>关注</a>
        <a href="javascript:;" ui-share data-type="box"
           data-pic="{{ $pics->first()->path or '' }}"
           data-title="{{ $detail->name }}"
           data-description="{{ $detail->description }}"
        ><i class="iconfont icon-fengxiang"></i>分享</a>
    </div>
</div>