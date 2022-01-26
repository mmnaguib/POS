@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li><i class="fa fa-users"></i><a href="{{ route('users.index') }}">@lang('site.users')</a></li>
                <li class="active"></li>@lang('site.add')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div>
                <div class="box-body">
                    @include('partials._errors')
                    <form method="POST" action="{{ route('users.store') }}" autocomplete="off" enctype="multipart/form-data">@csrf
                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.last_name')</label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" class="form-control" name="email"  value="{{ old('email') }}" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.password')</label>
                            <input type="password" class="form-control"  name="password" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.password_confirmation')</label>
                            <input type="password" class="form-control" name="password_confirmation" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.user_image')</label>
                            <input type="file" class="form-control image" name="image" />
                        </div>
                        <img src="{{ asset('images/default.png') }}" width="100" class="img-thumbnail image-preview"/>
                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">
                                <?php
                                    $models = ['users', 'categories', 'products'];
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
                                                <input type="checkbox" name="permission[]" value="{{ $model }}_{{ $crud }}" id="{{ $crud }}"/> @lang('site.'.$crud)</label>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
