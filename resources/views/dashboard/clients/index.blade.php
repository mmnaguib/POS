@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li class="active"></li>@lang('site.clients')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.clients')</h3><br><br>
                    <form action="{{ route('clients.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" placeholder="@lang('site.search')" name="search" class="form-control" value="{{ request()->search }}"/>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('clients_create'))
                                    <a class="btn btn-info btn-sm" href="{{ route('clients.create') }}"><i class="fa fa-plus"></i> @lang('site.add') @lang('site.client')</a>
                                @else
                                    <a class="btn btn-info btn-sm" disabled href="#"><i class="fa fa-plus"></i> @lang('site.add') @lang('site.client')</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    @if (count($clients) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.client_name')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.address')</th>
                                    <th>@lang('site.add_order')</th>
                                    <th>@lang('site.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $index=>$client)
                                <tr>
                                    <th>{{ $index+1 }}</th>
                                    <th>{{ ucfirst($client->name) }}</th>
                                    <th>{{ implode(array_filter($client->phone), ' - ') }}</th>
                                    <th>{{ $client->address }}</th>
                                    <th>
                                        @if (auth()->user()->haspermission('orders_create'))
                                            <a href="{{ route('client.orders.create', $client->id) }}" class="btn btn-primary btn-sm">@lang('site.add_order')</a>
                                        @endif
                                    </th>
                                    <th>
                                        @if(auth()->user()->hasPermission('clients_update'))
                                            <a class="btn btn-info btn-sm" href="{{ route('clients.edit', $client->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-info btn-sm" disabled href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('clients_delete'))
                                        <form method="POST" action="{{ route('clients.destroy', $client->id) }}" style="display: inline-block"> @csrf
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
            {{ $clients->appends(request()->query())->links('pagination::bootstrap-4') }}
        </section>
    </div>
@endsection
