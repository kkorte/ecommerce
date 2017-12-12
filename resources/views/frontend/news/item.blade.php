@extends('frontend._layouts.default')
@section('meta_title', $news['meta_title'])
@section('meta_description', $news['meta_description'])
@section('meta_keywords', $news['meta_keywords'])
@section('main')
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/nieuws">Nieuws</a></li>
            <li><a href="{!! URL::route('news.group', array($news->newsGroup->slug)) !!}">{{ $news->newsGroup->title }}</a></li>
            <li><a href="/{{ $news->slug }}">{{ $news->title }}</a></li>
        </ul>
    </div>
</div>



<div class="news">
    <div class="row">

        <div class="col-lg-3">

            <div class="news-sidebar">
                <h3>Nieuwsgroepen</h3>
                @if($newsGroups)
                <ul>
                @foreach($newsGroups as $group)
                    <li><a href="{!! URL::route('news.group', array($group->slug)) !!}">{{ $group->title }}</a></li>
                @endforeach
                </ul>
                @endif

            </div>
       
     
        </div>  




        <div class="col-lg-9">


            <div class="row product-container">

                <div class="large-3 columns">
                    @if ($news->newsImages)
                    <div class="photos photo-container">
                        <div class="row">
                            @foreach ($news->newsImages as $key => $image)
                            @if ($key === 0)
                            <div class="large-photo">    
                                <div class="large-15 columns">
                                    <a href="/files/news/800x800/{!! $image['news_id'] !!}/{!! $image['file'] !!}">
                                        <img src="/files/news/400x400/{!! $image['news_id'] !!}/{!! $image['file'] !!}" class="img-responsive main-photo" alt="" />
                                    </a>
                                </div>    

                            </div>             

                            @else
                            <div class="small-photo">

                                <div class="large-5 columns">
                                    <a href="/files/news/800x800/{!! $image['news_id'] !!}/{!! $image['file'] !!}">
                                        <img src="/files/news/400x400/{!! $image['news_id'] !!}/{!! $image['file'] !!}" class="img-responsive" alt="" />
                                    </a>
                                </div>
                            </div>
                            @endif


                            @endforeach

                        </div>

                    </div>
                    @else
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="{!! URL::asset('images/default-thumb.jpg') !!}" alt="no image" class="img-responsive">
                        </div>
                    </div>
                    @endif
                </div>

                <div class="columns large-offset-1  large-11">
                    <h1>{!! $news->title !!}</h1>
                    <div class="description">

                        {!! $news->content !!}
                        
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@stop