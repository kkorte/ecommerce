<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Frontend" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('meta_title')</title>
		<link rel="stylesheet" href="{{ URL::asset('/css/frontend.css')}}">  
    </head>
    <body>
        @include('frontend._partials.header')
        <div class="container-fluid">      
            @yield('main')
        </div>

        @include('frontend._partials.footer')
        <script src="{{ URL::asset('/js/frontend.js')}}"></script>
    </body>
</html>