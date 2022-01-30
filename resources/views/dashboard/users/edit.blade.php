@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li><i class="fa fa-users"></i><a href="{{ route('users.index') }}">@lang('site.users')</a></li>
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
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">@csrf
                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.last_name')</label>
                            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" class="form-control" name="email"  value="{{ $user->email }}" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.user_image')</label>
                            <input type="file" class="form-control image" name="image" />
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('images/' . $user->user_image ) }}" width="100" class="img-thumbnail image-preview"/>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">
                                <?php
                                    $models = ['users', 'categories', 'products','clients','orders'];
                                    $cruds = ['create','read','update','delete'];
                                ?>
                                <ul class="nav nav-tabs">
                                    @foreach ($models as $index=>$model)
                                        <li class =' {{ $index == 0 ? "active": "" }} '><a href="#{{ $model }}" data-toggle="tab">@lang('site.'. $model )</a></li>
                                    @endforeach

                                </ul>
                                <div class="tab-content">
                                    @foreach ($models as $index=>$model)
                                    <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                        @foreach ($cruds as $crud)
                                            <label for="{{ $crud }}">
                                                <input type="checkbox" name="permission[]" {{ $user->hasPermission($model .'_'. $crud) ? 'checked' : '' }} value="{{ $model }}_{{ $crud }}" id="{{ $crud }}"/> @lang('site.'.$crud)</label>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
