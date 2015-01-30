<!DOCTYPE HTML>
<!--
	Strata by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>{{ trans('web.title') }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    @section ('headlink')
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}" />

    @show

    @section ('headscript')
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="/js/html5shiv.js" type="text/javascript"></script>
        <script src="/js/respond.js" type="text/javascript"></script>
        <![endif]-->
    @show

</head>

<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">{{ trans('web.title') }}</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('admin') }}">{{ trans('web.home') }}</a></li>
                <li><a href="{{ route('services.index') }}">{{ trans('admin.services') }}</a></li>
                <li><a href="{{ route('blocks.index') }}">{{ trans('admin.blocks') }}</a></li>
                <li><a href="{{ route('users.index') }}">{{ trans('admin.users') }}</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ trans('web.url_github_repo') }}" class="navbar-brand"><i class="fa fa-github"></i></a></li>
                <li><a href="{{ trans('web.url_twitter') }}" class="navbar-brand"><i class="fa fa-twitter"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    @include('flash::message')
</div>

@yield('content')


<footer class="container">
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-inline">
                <li class="pull-right"><a href="#top">{{ trans('web.back_to_top') }}</a></li>
                <li><a href="{{ trans('web.url_twitter') }}"><i class="fa fa-twitter"></i></a></li>
                <li><a href="{{ trans('web.url_github_repo') }}"><i class="fa fa-github"></i></a></li>
            </ul>
            <p>Built with <a href="http://bootswatch.com/">Bootstwatch</a>.</p>
            <p>Code released under the <a href="http://opensource.org/licenses/MIT">MIT License</a>.</p>
        </div>
    </div>
</footer>

@section('inlinescript')
<script src="/js/all.js"></script>
@show

</body>
</html>
