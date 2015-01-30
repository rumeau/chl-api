@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="well">
            <h2>{{ trans('admin.welcome', ['name' => Auth::user()->name]) }}</h2>
        </div>
    </div>

@stop