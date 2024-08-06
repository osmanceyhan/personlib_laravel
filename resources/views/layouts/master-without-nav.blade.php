<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.title-meta')
    @include('layouts.head')
</head>

@section('body')
    <div class="loader_body">
        <div class="loader"></div>

    </div>

    <body class="authentication-bg">
    @show
    @yield('content')
    @include('layouts.vendor-scripts')
</body>

</html>
