<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/css/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/css/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/css/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/css/daterangepicker.css" rel="stylesheet">
    <!-- Bootstrap Colorpicker -->
    <link href="/css/bootstrap-colorpicker.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/css/custom.min.css" rel="stylesheet">

    <style>
        .container{width:100%;padding:0}
    </style>
    @stack('styles')

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ route('admin') }}" class="site_title"><span></span></a>
                </div>

                <div class="clearfix"></div>

                <br />

                @include('layouts.parts.sidebar')


            </div>
        </div>

        @include('layouts.parts.top-navigation')

        <!-- page content -->
        <div class="right_col" role="main">


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="pull-left">@yield('title')</h2>
                            <div class="nav pull-right panel_toolbox col-md-5 col-sm-5 col-xs-12">
                                @yield('toolbox')
                            </div>

                            <div class="clearfix"></div>

                        </div>
                        <div class="x_content">
                            @include('layouts.parts.messages')
                            <br>

                            @yield('content')

                        </div>
                    </div>
                </div>

            </div>
            <br />


                    </div>
                </div>
            </div>


        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                {{ env('APP_NAME') }}
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/js/fastclick.js"></script>
<!-- NProgress -->
<script src="/js/nprogress.js"></script>
<!-- Chart.js -->
<script src="/js/Chart.min.js"></script>
<!-- gauge.js -->
<script src="/js/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="/js/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="/js/icheck.min.js"></script>
<!-- Skycons -->
<script src="/js/skycons.js"></script>
<!-- Flot -->
<script src="/js/jquery.flot.js"></script>
<script src="/js/jquery.flot.pie.js"></script>
<script src="/js/jquery.flot.time.js"></script>
<script src="/js/jquery.flot.stack.js"></script>
<script src="/js/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/js/jquery.flot.orderBars.js"></script>
<script src="/js/jquery.flot.spline.min.js"></script>
<script src="/js/curvedLines.js"></script>
<!-- DateJS -->
<script src="/js/date.js"></script>
<!-- JQVMap -->
<script src="/js/jquery.vmap.js"></script>
<script src="/js/jquery.vmap.world.js"></script>
<script src="/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="/js/moment.min.js"></script>
<script src="/js/daterangepicker.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="/js/push_notification.min.js"></script>

@stack('custom-scripts')

<!-- Custom Theme Scripts -->
<script src="/js/custom.min.js"></script>

<!-- App scripts including Echo -->
<script src="/js/app.min.js"></script>


@stack('scripts')

<script>

    $(function(){

    });
</script>


</body>
</html>
