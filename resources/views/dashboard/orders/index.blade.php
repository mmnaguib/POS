@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.orders')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li class="active"></li>@lang('site.orders')</li>
            </ol>
        </section>
        <section class="content">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.orders')</h3><br><br>
                        <form action="{{ route('orders.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" placeholder="@lang('site.search')" name="search" class="form-control" value="{{ request()->search }}"/>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-body">
                        @if (count($orders) > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.client_name')</th>
                                        <th>@lang('site.price')</th>
                                        <th>@lang('site.status')</th>
                                        <th>@lang('site.created_at')</th>
                                        <th>@lang('site.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $index=>$order)
                                    <tr>
                                        <th>{{ $index+1 }}</th>
                                        <th>{{ $order->client->name }}</th>
                                        <th>{{ number_format($order->total_price, 2) }}</th>
                                        <th>{{ $order->address }}</th>
                                        <th>{{ $order->created_at }}</th>
                                        <th>
                                            <button class="btn btn-primary btn-sm order-products" data-url="{{ route('orders.products', $order->id) }}"><i class="fa fa-list"></i> @lang('site.show')</button>
                                            @if(auth()->user()->hasPermission('orders_update'))
                                                <a class="btn btn-info btn-sm" href="{{ route('client.orders.edit',['client' => $order->client->id, 'order' => $order->id]) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @else
                                                <a class="btn btn-info btn-sm" disabled href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if(auth()->user()->hasPermission('orders_delete'))
                                            <form method="POST" action="{{ route('orders.destroy', $order->id) }}" style="display: inline-block"> @csrf @method('DELETE')
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

                {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.show_products')</h3><br><br>
                    </div>
                    <div id="loading" style="display: none;flex-direction: column;align-items: center;justify-content: center">
                        <div class="loader"></div>
                        <p style="margin-top: 10px;">@lang('site.loading')</p>
                    </div>
                    <div id="order-product-list"></div>
                </div>
            </div>
        </section>
    </div>
@endsection
