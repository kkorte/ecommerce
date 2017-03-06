@extends('frontend._layouts.default')
@section('meta_title', $content['meta_title'])
@section('meta_description', $content['meta_description'])
@section('meta_keywords', $content['meta_keywords'])
@section('main')

<div class="breadcrumb">
    <div class="row">
        <div class="small-12 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>

                    <li><a href="/text/{{ $content->slug }}">{{ $content->title }}</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">


        <div class="small-4 show-for-medium medium-4 large-4 columns">
            <div class="content-items-summary">
                <h5>Lees ook...</h5>
                @if($allContent)
                <ul>
                    @foreach($allContent as $contentItem)
                    <li><a href="/text/{{ $contentItem->slug }}">{!! $contentItem->title !!}</a></li>
                    @endforeach
                </ul>
                @endif
            </div>

        </div>


        <div class="small-15 medium-11 large-11 columns">
            <div class="content-text">
                <div class="row">
                    <div class="columns small-15 medium-15 large-15">
                        <h1>{!! $content->title !!}</h1>

                    </div>
                </div>


                <div class="row product-container">


                    <div class="columns small-15 medium-15 large-15">

                        <div class="description">

                            {!! $content->content !!}
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@stop