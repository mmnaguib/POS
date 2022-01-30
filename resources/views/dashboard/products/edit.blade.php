@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li><i class="fa fa-products"></i><a href="{{ route('products.index') }}">@lang('site.products')</a></li>
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
                    <form method="POST" action="{{ route('products.update', $product->id) }}" autocomplete="off" enctype="multipart/form-data">@csrf

                        <div class="form-group">
                            <label>@lang('site.category')</label>
                            <select class="form-control" name="category"  value="{{ old('category') }}" >
                                <option value="" disabled >---- اختر ----</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('site.' . $locale . '.product_name')</label>
                            <input type="text" class="form-control" name="{{ $locale }}_product_name" value="{{ $product->setLocale($locale)->name}}" />
                        </div>
                        <div class="form-group">
                            <label>@lang('site.' . $locale . '.product_desc')</label>
                            <textarea class="form-control ckeditor" name="{{ $locale }}_product_desc" cols="10" rows="3">{{ $product->setLocale($locale)->description}}</textarea>
                        </div>
                        @endforeach
                        <div class="form-group">
                            <label>@lang('site.product_image')</label>
                            <input type="file" class="form-control image" name="image" />
                        </div>
                        <img src="{{ asset('images/products/' . $product->image) }}" width="100" class="img-thumbnail image-preview"/>
                        <div class="form-group">
                            <label>@lang('site.purchase_price')</label>
                            <input type="number" step="any" class="form-control" name="purchase_price" value="{{ $product->purchase_price }}"/>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.sale_price')</label>
                            <input type="number" step="any" class="form-control" name="sale_price"  value="{{ $product->sale_price }}"/>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.stock')</label>
                            <input type="number" min="1" class="form-control" name="stock"  value="{{ $product->stock }}"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
