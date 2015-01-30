@extends('app')

@section('content')

    <div class="container">
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-6">
                    <h1>{{ trans('web.title') }}</h1>
                    {!! trans('web.summary') !!}
                </div>
                <div class="col-lg-4 col-md-5 col-sm-6"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>{{ trans('web.apis_available') }}</h2>
        </div>

        <div class="row">
            @foreach ($services as $service)
            <article class="col-md-3">
                <div class="thumbnail">
                    <a href="{{ route('services.view', ['service' => $service]) }}" title="{{ $service->title }}">
                        <img src="{{ isset($service->image) ? asset('/uploads/' . $service->image) : 'http://lorempixel.com/300/200/abstract' }}" alt="" class="img-responsive"/></a>
                    <div class="caption">
                        <h3>{{ $service->title }}</h3>
                        {!! $service->summary['html'] !!}
                        <p class="text-center">
                            <a class="btn btn-default"
                               href="{{ route('services.view', ['service' => $service]) }}">{{ trans('web.view') }}</a>
                        </p>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>

@stop