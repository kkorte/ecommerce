@extends('frontend._layouts.default')

@if($category['meta_title'])
@section('meta_title', $category['meta_title'])
@else
@section('meta_title', $category->title)
@endif

@if($category['meta_description'])
@section('meta_description', $category['meta_description'])
@else
@section('meta_description', $category->short_description)
@endif

@section('meta_keywords', $category['meta_keywords'])


@section('main')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            @if($category->ancestors()->count())
            @foreach ($category->ancestors()->get() as $anchestor)
            <li><a href="/{{ $anchestor->slug }}">{{ $anchestor->title }}</a></li>
            @endforeach
            @endif
            <li><a href="/{{ $category->slug }}">{{ $category->title }}</a></li>
        </ol>
    </div>
</div>



@if (isset($category->products))
<div class="row">
    @if( $products )
    @foreach ($products as $product)


        @include('frontend.product_category._product-row-item')
    @endforeach
    @endif
</div>
@endif


@stop