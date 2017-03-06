@extends('frontend._layouts.default')
@if($brand['meta_title'])
@section('meta_title', $brand['meta_title'])
@else
@section('meta_title', $brand->title.' | Foodelicious')
@endif

@section('meta_description', $brand->meta_description)
@section('meta_keywords', $brand->meta_keywords)
@section('main')

<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="/merken-overzicht">merken</a></li>
                    <li><a href="#">{{ $brand->title }}</a></li>

                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="products">


    <div class="row">

          <div class="show-for-large small-12 medium-12 large-3 columns">
            <div class="category-sidebar">
                @if ($brands)
                <ul class="category-navigation">
                    @foreach ($brands as $brandRow)
                    @if($brand->slug == $brandRow->slug)
                    <a href="/merk/{{ $brandRow['slug'] }}" class="current" title="ga naar {{ $brandRow['title'] }}">
                        <li>{{ $brandRow['title'] }}</li>
                    </a>
                    @else 
                    <a href="/merk/{{ $brandRow->slug }}" title="ga naar {{ $brandRow->title }}">
                        <li>{{ $brandRow->title }}</li>
                    </a>
                    @endif
                    @endforeach
                </ul>
                @endif
            </div>
        </div>    



        <div class="small-15 medium-15  large-offset-1 large-11 columns">

            <div class="row">
                <div class="small-15 medium-8 large-8 columns">  
                    <h1>{{ $brand->title }}</h1>
                    <div class="hide-for-medium">
                        <p>{!! $brand->short_description !!}</p> 
                    </div> 
                    <div class="show-for-medium">
                        {!! $brand->description !!}   
                    </div> 
                </div>
                <div class="show-for-medium small-12 medium-6 medium-offset-1 large-offset-1 large-6 columns text-right">    

                    @if($brand->brandImages->count())
                    <img src="/files/brand/200x200/{!! $brand->brandImages->first()->brand_id !!}/{!! $brand->brandImages->first()->file !!}" class="img-responsive main-photo" alt="" />
                    @endif   

                </div>  
            </div>    

            @if (isset($brand->products))
            <div class="row blocks" data-equalizer data-equalize-on="medium">
                @if( $products )
                @foreach ($products as $product)
                    @include('frontend.product_category._product-row')
                @endforeach
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="reveal" id="exampleModal1" data-reveal></div>

    
</div>
@stop