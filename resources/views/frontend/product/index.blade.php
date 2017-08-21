@extends('frontend._layouts.default')

@section('main')

<div class="row">
    <div class="col-sm-3 col-md-2">
        <ol class="breadcrumb">
            <li class="show-for-medium"><a href="/">Home</a></li>
            @if($product->productCategory->ancestors()->count())
            @foreach ($product->productCategory->ancestors()->get() as $anchestor)
            <li><a href="{!! URL::route('product-category.item', $anchestor->slug) !!}">{{ $anchestor->title }}</a></li>
            @endforeach          
            @endif
            <li><a href="{!! URL::route('product-category.item', $product->productCategory->slug) !!}">{{ $product->productCategory->title }}</a></li>
            <li><a href="#">{{ $product->title }}</a></li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-sm-3 col-md-2">
        {!! $product->title !!}
    </div>
</div>

@stop