@extends('frontend._layouts.default')

@if($category['meta_title'])
@section('meta_title', $category['meta_title'])
@else
@section('meta_title', $category->title.' | Foodelicious')
@endif

@section('meta_description', $category->meta_description)
@section('meta_keywords', $category->meta_keywords)
@section('main')

<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-15 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    @if($category->ancestors()->count())
                    @foreach ($category->ancestors()->get() as $anchestor)
                    <li><a href="/{{ $anchestor->slug }}">{{ $anchestor->title }}</a></li>
                    @endforeach
                    @endif
                    <li><a href="/{{ $category->slug }}">{{ $category->title }}</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>            

<div class="categories">

    <div class="intro">
        <div class="row">
            <div class="small-15 medium-8 large-8 columns">  
                <h1>{{ $category->title }}</h1>
                <div class="hide-for-medium">
                    <p>{!! $category->short_description !!}</p>  
                </div> 
                <div class="show-for-medium">
                    {!! $category->description !!}   
                </div>
            </div>
            <div class="show-for-medium medium-5 medium-offset-2 large-offset-2 large-5 columns text-right">    
                @if($category->productCategoryImages->count())
                <img src="/files/product_category/200x200/{!! $category->productCategoryImages->first()->product_category_id !!}/{!! $category->productCategoryImages->first()->file !!}" class="" alt="" />
                @endif
            </div>  
        </div>  
    </div>

    @if ($childrenProductCategories)

    @foreach ($childrenProductCategories->chunk(3) as $categories)
    <div class="row ">
        @foreach ($categories as $category)
        <div class="small-15 medium-5 large-5 columns">
            <div class="category-block">
                <div class="row">
                    <a href="/{{ $category['slug'] }}" title="ga naar {{ $category['title'] }}">
                        <div class="small-5 medium-5 large-5 columns">

                            <div class="image"> 
                                @if($category->productCategoryImages->count())
                                <img src="/files/product_category/200x200/{!! $category->productCategoryImages->first()->product_category_id !!}/{!! $category->productCategoryImages->first()->file !!}" class="img-responsive main-photo" alt="" />          
                                <div class="overlay"></div>
                                @endif
                            </div>

                        </div>
                        
                        <div class="small-10 medium-10 large-10 columns">
                            <div class="category-block-content">
                                <h3>{{ str_limit($category['title'],21) }}</h3>
                                <p class="hide-for-medium-only">{{ $category->short_description  }}</p>

                            </div>
                        </div>
                    </a>
                </div>
            </div>            
        </div>
        @endforeach
    </div>
    @endforeach
    @endif
</div>
@stop