
@extends('hideyo_frontend::_layouts.default')

@section('main')


<h1>{!! $productCategory->title !!}</h1>
{!! $productCategory->description !!}

@if($products)
<ul>
@foreach($products as $product)
<li>
    <a href="{!! URL::route('hideyof.product.item', array('productCategory' => $product->productCategory->slug, 'productId' => $product->id, 'productSlug' => $product->slug)) !!}" title="go to product">
        {!! $product->title !!}
    </a>
</li>
@endforeach
</ul>
@endif


@stop


