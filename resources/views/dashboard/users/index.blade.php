@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li class="active"></li>@lang('site.users')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.users')</h3><br><br>
                    <form action="{{ route('users.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" placeholder="@lang('site.search')" name="search" class="form-control" value="{{ request()->search }}"/>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('users_create'))
                                    <a class="btn btn-info btn-sm" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> @lang('site.add') @lang('site.user')</a>
                                @else
                                    <a class="btn btn-info btn-sm" disabled href="#"><i class="fa fa-plus"></i> @lang('site.add') @lang('site.user')</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    @if (count($users) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.first_name')</th>
                                    <th>@lang('site.last_name')</th>
                                    <th>@lang('site.email')</th>
                                    <th>@lang('site.user_image')</th>
                                    <th>@lang('site.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index=>$user)
                                <tr>
                                    <th>{{ $index+1 }}</th>
                                    <th>{{ ucfirst($user->first_name) }}</th>
                                    <th>{{ ucfirst($user->last_name) }}</th>
                                    <th>{{ $user->email }}</th>
                                    <th><img src="{{ asset('images\\'. $user->user_image) }}" width="100px" class="img-thumbnail"/> </th>
                                    <th>
                                        @if(auth()->user()->hasPermission('users_update'))
                                            <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-info btn-sm" disabled href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('users_delete'))
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display: inline-block"> @csrf
                                            <button type="submit" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        </form>
                                        @else
                                            <button type="submit" disabled class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        @endif
                                    </th>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h1>@lang('site.not_data_found')</h1>
                    @endif
                </div>
            </div>
            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
        </section>
    </div>
@endsection
