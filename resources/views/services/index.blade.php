@extends('app')

@section('content')

    <div class="container">
        <div class="page-header">
            <h1>{{ $service->title }}</h1>
        </div>
        {!! $service->body['html'] !!}
    </div>

@stop