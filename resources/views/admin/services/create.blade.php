@extends('layouts.admin')

@section('content')

    <div class="container">

        <div class="page-header">
            <h2>{{ trans('admin.new_service') }}</h2>
        </div>

        <form class="form-vertical" action="/web/admin/services/store" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Title input -->
            <div class="form-group{!! $errors->has('title') ? ' has-error' : '' !!}">
                <label class="control-label" for="title">{{ trans('admin.title') }}</label>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="title" class="form-control"
                               value="{{ Input::old('title') }}" placeholder="{{ trans('admin.title') }}" />
                    </div>
                    {!! $errors->first('title', '<p class="help-block col-md-12">:message</p>') !!}
                </div>
            </div>

            <!-- Summary input -->
            <div class="form-group{!! $errors->has('summary') ? ' has-error' : '' !!}">
                <label class="control-label" for="summary">{{ trans('admin.summary') }}</label>
                <div class="row">
                    <div class="col-md-12">
                        <div class="editor-container">
                            <div id="id-summary-container"></div>
                            <textarea name="summary" class="form-control" rows="5" data-editor="epiceditor"
                                      id="id-summary" placeholder="">{{ Input::old('summary') }}</textarea>
                        </div>
                    </div>
                    {!! $errors->first('summary', '<p class="help-block col-md-12">:message</p>') !!}
                </div>
            </div>

            <!-- Body input -->
            <div class="form-group{!! $errors->has('body') ? ' has-error' : '' !!}">
                <label class="control-label" for="body">{{ trans('admin.body') }}</label>
                <div class="row">
                    <div class="col-md-12">
                        <div class="editor-container">
                            <div id="id-body-container"></div>
                            <textarea name="body" class="form-control" rows="10" data-editor="epiceditor"
                                      id="id-body" placeholder="">{{ Input::old('body') }}</textarea>
                        </div>
                    </div>
                    {!! $errors->first('body', '<p class="help-block col-md-12">:message</p>') !!}
                </div>
            </div>

            <!-- Version input -->
            <div class="form-group{!! $errors->has('api') ? ' has-error' : '' !!}">
                <label class="control-label" for="api">{{ trans('admin.api_version') }}</label>
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('admin.version') }}</span>
                            <input type="number" name="api" class="form-control"
                                   value="{{ Input::old('api', 1) }}" placeholder="" />
                        </div>
                    </div>
                    {!! $errors->first('api', '<p class="help-block col-md-12">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">
                <a class="btn btn-default" href="/web/admin/services">&larr; {{ trans('admin.cancel') }}</a>
                <button type="submit" class="btn btn-primary">{{ trans('admin.save') }}</button>
            </div>
        </form>
    </div>

@stop

@section('headscript')
    @parent

@stop
@section('headlink')
    @parent

@stop