@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li><i class="fa fa-clients"></i><a href="{{ route('clients.index') }}">@lang('site.clients')</a></li>
                <li class="active"></li>@lang('site.edit')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div>
                <div class="box-body">
                    @include('partials._errors')
                    <form method="POST" action="{{ route('clients.update', $client->id) }}" enctype="multipart/form-data">@csrf
                        <div class="form-group">
                            <label>@lang('site.client_name')</label>
                            <input type="text" class="form-control" name="client_name" value="{{ $client->name }}" />
                        </div>
                        @for($i=0; $i<2; $i++)
                            <div class="form-group">
                                <label>@lang('site.phone')</label>
                                <input type="text" class="form-control" name="phone[]" value="{{ $client->phone[$i] ?? ''}}"/>
                            </div>
                        @endfor
                        <div class="form-group">
                            <label>@lang('site.address')</label>
                            <input type="text" class="form-control" name="address"  value="{{ $client->address }}" />
                        </div>
                        <!--<div class="form-group">
                            <label>@lang('site.client_image')</label>
                            <input type="file" class="form-control image" name="image" />
                        </div>
                        <img src="{{ asset('images/default.png') }}" width="100" class="img-thumbnail image-preview"/>-->

                        <div class="form-group">
                            <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
