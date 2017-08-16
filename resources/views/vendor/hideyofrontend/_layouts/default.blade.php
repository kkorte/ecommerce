<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Frontend" />
        <meta name="author" content="" />

        <title>Frontend</title>

        @include('hideyo_frontend::_partials.assets')
    </head>
    <body>
        @include('hideyo_frontend::_partials.header')
        <div class="container">
      
            @yield('main')
        </div>

        @include('hideyo_frontend::_partials.footer')
    </body>
</html>