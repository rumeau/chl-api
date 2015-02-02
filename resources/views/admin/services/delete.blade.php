@extends('layouts.admin')

@section('content')

    <div class="container">

        <div class="page-header">
            <h2>{{ trans('admin.delete_service') }}</h2>
        </div>

        <div class="well">
            {!! trans('admin.delete_service_agree', ['service' => $service->title]) !!}

            <form action="{{ route('services.destroy', ['service' => $service]) }}" method="post">
                <p class="text-center">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="element" value="{{ $service->id }}" />

                    <a href="{{ route('services.index') }}" class="btn btn-default">&larr; {{ trans('admin.cancel') }}</a>
                    <button type="submit" class="btn btn-danger">{{ trans('admin.delete') }}</button>
                </p>
            </form>
        </div>

    </div>

@stop