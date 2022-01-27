@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li><i class="fa fa-categorys"></i><a href="{{ route('categories.index') }}">@lang('site.categories')</a></li>
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
                    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">@csrf
                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('site.' . $locale . '.name')</label>
                            <input type="text" class="form-control" name="{{ $locale }}_name" value="{{ $category->setLocale($locale)->name}}" />
                        </div>
                        @endforeach
                        <div class="form-group">
                            <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
