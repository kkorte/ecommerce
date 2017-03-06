@extends('frontend._layouts.default')

@section('meta_title', '')


@section('meta_description', '')
@section('meta_keywords', '')
@section('main')

<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-15 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="#">Merken</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>            

<div class="categories">

    <div class="intro">
        <div class="row">
            <div class="small-15 medium-8 large-8 columns">  

                    @if(HtmlBlockHelper::findByPosition("brand-intro"))  
                    {!! HtmlBlockHelper::findByPosition("brand-intro") !!}
                    @else 
                <h1>Merken</h1>
                <p>tekst</p>
                    @endif



            </div>

        </div>  
    </div>

    @if ($brands)

    @foreach ($brands['result']->chunk(3) as $brands)
    <div class="row ">
        @foreach ($brands as $brand)
        <div class="small-15 medium-5 large-5 columns">
            <div class="category-block">
                <div class="row">
                    <a href="/merk/{{ $brand['slug'] }}" title="ga naar {{ $brand['title'] }}">
                        <div class="small-5 medium-5 large-5 columns">

                            <div class="image"> 
                                @if($brand->brandImages->count())
                                <img src="/files/brand/200x200/{!! $brand->brandImages->first()->brand_id !!}/{!! $brand->brandImages->first()->file !!}" class="img-responsive main-photo" alt="" />          
                                <div class="overlay"></div>
                                @endif
                            </div>

                        </div>
                        
                        <div class="small-10 medium-10 large-10 columns">
                            <div class="category-block-content">
                                <h3>{{ str_limit($brand['title'],21) }}</h3>
                                <p>{{ $brand->short_description  }}</p>

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