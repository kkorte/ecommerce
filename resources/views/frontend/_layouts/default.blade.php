<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title')</title>
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />
    <link rel="shortcut icon" type="image/x-icon" href="{!! URL::to('/favicon.ico') !!}">
    @if(isset($og))
    {!! $og->renderTags() !!}
    @endif
    <link href="/css/style.css" rel="stylesheet">
</head>
<body class="other">
    @include('googletagmanager::script')
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <div class="off-canvas position-left" id="offCanvasLeft" data-url="/menu-canvas" data-off-canvas data-position="left">

                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>

                <ul class="off-menu">
                    <li><a href="/">Home</a><li>
                    @foreach($frontendProductCategories as $productCategory)
                    <li><a href="{!! URL::route('product-category', $productCategory->slug) !!}">{!! $productCategory->title !!}</a></li>
                    @endforeach

                    <li><a href="/merken-overzicht">merken</a><li>

                    <li><a href="/account">account</a></li>

                </ul>

            </div>
            <div class="off-canvas-content" data-off-canvas-content>
                @if(BrowserDetect::isMobile() )

                @include('frontend._partials.header-mobile')

                @else
                @include('frontend._partials.header')
                @endif    
                <div class="main">
                    @yield('main')
                </div>
                @include('frontend._partials.footer')
                <!-- COMPILED JAVASCRIPT - POWER OF GULP -->
                <script src="/javascript/site.js"></script>
            </div>
        </div>
    </div>
</body>
</html>