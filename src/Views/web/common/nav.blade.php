<!-- 头部 -->
<div class="in_header">
    <header>
        <div class="in_nav ">
            <div class="w_1200">
                <ul class="fl">
                    <li>
                        @if(Auth::check()) {{Auth::user()->name}}@endif 欢迎来到木头来了！
                    </li>
                    @if(Auth::check())
                        <li>
                            &nbsp;&nbsp;&nbsp; &nbsp;<a
                                    href="{{U('logout',['returnUrl'=>request("returnUrl",request()->getUri())])}}"
                                    rel="nofollow" class="col-a">退出</a>
                        </li>
                    @else
                        <li>
                            请<a href="{{U('login',['returnUrl'=>request("returnUrl",request()->getUri())])}}"
                                rel="nofollow" class="col-a">登录</a>
                        </li>
                        <li class="pr"></li>
                        <li><a href="{{U('register',['returnUrl'=>request("returnUrl",request()->getUri())])}}"
                               rel="nofollow">免费注册</a></li>
                    @endif
                </ul>
                <ul class="fr">
                    <li><a href="{{ url("user/index") }}">个人中心</a></li>
                    <li class="pr"></li>
                    <li><a href="{{ url('user/order') }}">我的订单</a></li>
                    <li class="pr"></li>
                    <li><a href="{{ url("order/cart") }}">购物车<span class="col-a">(<i
                                        ui-cartnum>{{ $cart_num or '0' }}</i>)</span></a></li>
                    <li class="pr"></li>
                    <li>咨询热线：028-85551477</li>
                </ul>
            </div>
        </div>

        <div class="h_cent w_1200">
            <h1 class="logo h_icon"><a href="{{url('/')}}" title="木头来了"><img
                            src="{{ config('sys.sys_static_url') }}mutou/pc/common/images/logo.jpg" alt="木头来了"></a></h1>
            <a class="h_img" href="{{ url('special/train20170515.html') }}" target="_blank">
                <img src="{{ config('sys.sys_static_url') }}mutou/pc/common/images/train.gif" alt="蓉欧列车"/>
            </a>
            {{--搜索--}}
            <div class="h_search">
                <div class="form">
                    <form action="{{ route('web.commodity.search') }}" method="get">
                        <input type="text" name="keyword" class="text" data-value="{{ request()->input('keyword', '克诺斯邦') }}" value="{{ request()->input('keyword', '克诺斯邦') }}" onfocus="if($(this).val() == $(this).data('value') ){$(this).val('')}" onblur="if($(this).val() == ''){$(this).val($(this).data('value'))}" />
                        <input type="submit" class="button" value="搜索"/>
                    </form>
                    <p class="tab"><a href="">供应</a></p>
                    <div class="link">
                        热门搜索：
                        <a href="{{ route('web.commodity.search', ['keyword' => '饰面板']) }}">饰面板</a>
                        <a href="{{ route('web.commodity.search', ['keyword' => '素板']) }}">素板</a>
                        <a href="{{ route('web.commodity.search', ['keyword' => '门板']) }}">门板</a>
                        <a href="{{ route('web.commodity.search', ['keyword' => '地板']) }}">地板</a>
                        <a href="{{ route('web.commodity.search', ['keyword' => '原木']) }}">原木</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="h_bottom">
            <nav>
                <ul class="w_1200">
                    <li @if(Request::getRequestUri()=='/') class="active" @endif><a href="{{url('/')}}">首页</a></li>
                    <li @if(stristr(Request::getRequestUri(),'/goods')) class="active" @endif ><a target="_blank"
                                                                                                  href="{{ route('web.commodity.goods.index') }}">商城</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</div>