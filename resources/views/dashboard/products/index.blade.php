@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li class="active"></li>@lang('site.products')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.products')</h3><br><br>
                    <form action="{{ route('products.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" placeholder="@lang('site.search')" name="search" class="form-control" value="{{ request()->search }}"/>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('products_create'))
                                    <a class="btn btn-info btn-sm" href="{{ route('products.create') }}"><i class="fa fa-plus"></i> @lang('site.add') @lang('site.product')</a>
                                @else
                                    <a class="btn btn-info btn-sm" disabled href="#"><i class="fa fa-plus"></i> @lang('site.add') @lang('site.product')</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    @if (count($products) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.product_name')</th>
                                    <th>@lang('site.product_desc')</th>
                                    <th>@lang('site.purchase_price')</th>
                                    <th>@lang('site.sale_price')</th>
                                    <th>@lang('site.stock')</th>
                                    <th>@lang('site.product_image')</th>
                                    <th>@lang('site.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index=>$product)
                                <tr>
                                    <th>{{ $index+1 }}</th>
                                    <th>{{ $product->name }}</th>
                                    <th>{{ $product->description  }}</th>
                                    <th>{{ $product->purchase_price }}</th>
                                    <th>{{ $product->sale_price  }}</th>
                                    <th>{{ $product->stock }}</th>
                                    <th><img src="{{ asset('images\products\\'. $product->image) }}" width="100px" class="img-thumbnail"/> </th>
                                    <th>
                                        @if(auth()->user()->hasPermission('products_update'))
                                            <a class="btn btn-info btn-sm" href="{{ route('products.edit', $product->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-info btn-sm" disabled href="#"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('products_delete'))
                                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline-block"> @csrf
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
            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
        </section>
    </div>
@endsection
