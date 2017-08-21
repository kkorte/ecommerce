@extends('frontend._layouts.default')

@section('main')

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