@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li><i class="fa fa-clients"></i><a href="{{ route('clients.index') }}">@lang('site.clients')</a></li>
                <li class="active"></li>@lang('site.add')</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">@lang('site.categories')</h3>
                        </div>
                        <div class="box-body">
                            @foreach ($categories as $category)
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4 class="panel-title"><a data-toggle="collapse" href="#{{ str_replace(' ', '-', $category->name)  }}">{{ $category->name }}</a></h4>
                                        </div>
                                    </div>
                                    <div class="panel panel-collapse" id="{{ str_replace(' ', '-', $category->name)  }}">
                                        @if ($category->products->count() > 0)
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('site.product_name')</th>
                                                            <th>@lang('site.stock')</th>
                                                            <th>@lang('site.price')</th>
                                                            <th>@lang('site.add')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($category->products as $product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ $product->stock }}</td>
                                                            <td>{{ $product->sale_price }}</td>
                                                            <td>
                                                                <a href="#"
                                                                class="btn btn-success btn-sm add-product-btn"
                                                                id="product_{{ $product->id }}"
                                                                data-name="{{ $product->name }}"
                                                                data-id="{{ $product->id }}"
                                                                data-price="{{ $product->sale_price }}">
                                                                <i class="fa fa-plus"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div style="display: flex;justify-content: center">
                                                <strong>@lang('site.no_product_data')</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">@lang('site.orders')</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" action="{{ route('client.orders.store', $client->id) }}"> @csrf
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>@lang('site.product')</th>
                                            <th>@lang('site.quantity')</th>
                                            <th>@lang('site.price')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="order-list">
                                    </tbody>
                                </table>
                                <div>@lang('site.total'): <span class="total-price">0</span><input type="hidden" name="total" class="total-price-input"></div><br>
                                <div>
                                    <button type="submit" id="add-order-form-btn" class="btn btn-block btn-primary disabled">@lang('site.add_order')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if($client->orders->count() > 0)
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                    @lang('site.previous_orders')
                                    <small>{{ $orders->total() }}</small>
                                </h3>
                            </div>
                            <div class="box-body">
                                @foreach ($orders as $order)
                                    <div class="panel-group">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#{{ $order->created_at->format('d-m-y-s') }}">{{ $order->created_at->format('d-Y-M') }}</a>
                                                </h4>
                                                <div id="{{ $order->created_at->format('d-m-y-s') }}" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <ul class="list-group">
                                                            @foreach ($order->products as $product)
                                                            <li class="list-group-item">{{ $product->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
