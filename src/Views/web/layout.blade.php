<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ config('sys.sys_static_url') }}mutou/pc/common/common.css?v={{ config('sys.version') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ config('sys.sys_static_url') }}mutou/pc/mainsite/mainsite.css?v={{ config('sys.version') }}"/>
    @yield('header')
</head>
<body>
@include('Goods::web.common.nav')
@yield('content')
@yield('footer')
</body>
</html>
