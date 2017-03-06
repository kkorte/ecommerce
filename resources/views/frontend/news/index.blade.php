@extends('frontend._layouts.default')
@section('meta_title', 'Nieuws')
@section('meta_description', '')
@section('meta_keywords', '')
@section('main') 

<div class="breadcrumb">
    <div class="row">
        <div class="small-12 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="/nieuws">Nieuws</a></li>
                    <li><a href="/nieuws">Overzicht</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="products news">
    <div class="row">

        <div class="show-for-large small-12 medium-12 large-3 columns">

            <div class="news-sidebar">
                <h3>Nieuwsgroep</h3>
                @if($newsGroups)
                <ul>
                @foreach($newsGroups as $group)
                    <li><a href="{!! URL::route('news.group', array($group->slug)) !!}">{{ $group->title }}</a></li>
                @endforeach
                </ul>
                @endif

            </div>
       
     
        </div>  

        <div class="small-15 medium-15  large-offset-1 large-11 columns">

            @foreach ($news['result']->chunk(3) as $newschunk)
            <div class="row">
                @foreach ($newschunk as $news)
                <div class="small-15 medium-5 large-15 columns">

                    <div class="product-block news-block">
                        <div class="row">
                            <a href="{!! URL::route('news.item', array($news->newsGroup->slug, $news->slug)) !!}" title="ga naar {{ $news['title'] }}">

                                <div class="small-4 medium-2 large-3 columns">

                                    <div class="image"> 
                                        @if($news->newsImages->count())
                                        <img src="/files/news/200x200/{!! $news->newsImages->first()->news_id !!}/{!! $news->newsImages->first()->file !!}" class="" alt="" />          
                                        <div class="overlay"></div>
                                        @endif
                                    </div>

                                </div>


                                <div class="small-11 medium-9 large-12 columns">
                                    <div class="text"> 
                                        <h3>{{ $news['title'] }}</h3>
                                        <p>{{ $news->short_description  }}</p>
                                        <a href="{!! URL::route('news.item', array($news->newsGroup->slug, $news->slug)) !!}" class="show-for-large button float-right">Lees nieuws</a>        
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> 

                </div>
                @endforeach
            </div>
            @endforeach

            <div class="row news-filters">

                <div class="small-15 text-right columns">
                    @if($selectedPage != 1)
                    <a href="?page={!! $selectedPage - 1 !!}"><</a>
                    @endif
                    @if($news['totalPages'] != 1)
                    @for($i = 0; $i < $news['totalPages']; $i++)

                    @if($selectedPage == ($i + 1)) 
                    <a href="?page={!! $i + 1 !!}"><strong>{!! $i + 1 !!}</strong></a>
                    @else
                    <a href="?page={!! $i + 1 !!}">{!! $i + 1 !!}</a>
                    @endif
                    @endfor


                    @endif

                    @if($selectedPage != $news['totalPages'])
                    <a href="?page={!! $selectedPage + 1 !!}">></a>
                    @endif 
                </div>
            </div>

        </div>
    </div>
</div>
@stop
