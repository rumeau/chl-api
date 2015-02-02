@extends('layouts.admin')

@section('content')

    <div class="container">

        <div class="page-header">
            <h2>{{ trans('admin.services') }}</h2>
        </div>

        <div class="btn-toolbar text-right">
            <a class="btn btn-primary" href="{{ route('services.create') }}">
                <i class="fa fa-plus"></i> {{ trans('admin.new_service') }}
            </a>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 10px;">{!! sort_link($services, 'id', '#') !!}</th>
                <th>{!! sort_link($services, 'title', trans('admin.title')) !!}</th>
                <th>{!! sort_link($services, 'date', trans('admin.date')) !!}</th>
                <th>{!! sort_link($services, 'version', trans('admin.version')) !!}</th>
                <th class="col-md-1"></th>
            </tr>
            </thead>

            <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->title }}</td>
                    <td>{{ $service->created_at }}</td>
                    <td>V{{ $service->api }}</td>
                    <td class="text-center">
                        <a href="{{ route('services.edit', ['service' => $service]) }}" class="btn btn-primary btn-xs">
                            <i class="fa fa-edit"></i></a>
                        <a href="{{ route('services.delete', ['service' => $service]) }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
            <tr>
                <td colspan="5">{{ $services }}</td>
            </tr>
            </tfoot>
        </table>
    </div>

@stop
