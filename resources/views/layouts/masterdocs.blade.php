<!DOCTYPE HTML>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>@yield('title') | Jewel</title>
            <meta name="description" content="@yield('description')">
            
        <link rel="icon" href="{!! asset('favicon.png') !!}" type="image/x-icon">
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>

            {{-- APP STYLESHEETS --}}
        {!! HTML::style('css/app.css') !!}
        {!! HTML::style('css/font-awesome.css') !!}
        {!! HTML::style('css/prism.css') !!}
    </head>
    <body>

        {{-- APP CONTENT BEGINS --}}
        @include('layouts.partials.header-docs')
            <div class="wrapper docs">
                @yield('content')
            </div>
            {{-- MODALS --}}
            @yield('modal')
        @include('layouts.partials.footer')
        {{-- APP CONTENT ENDS --}}
        
        {{-- APP SCRIPTS --}}
        {!! HTML::script('js/app.js') !!}
        {!! HTML::script('js/prism.js') !!}
    </body>
</html>