@yield('css')
@yield('external_css')
<!-- Bootstrap Css -->
<link href="{{ URL::asset('/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('/assets/css/icons.css')}}" id="icons-style" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('/assets/css/style.css')}}?time={{time()}}" id="app-style" rel="stylesheet" type="text/css" />
