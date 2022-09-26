<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name') }} </title>
    <meta name="description" content="@yield('description')">
    <link rel="icon" href="{!! url('favicon.png') !!}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900,300" rel="stylesheet" type="text/css">
    {{-- APP STYLESHEETS --}} 
    <link rel="stylesheet" href="{!! url('css/app.css') !!}" type="text/css">
</head>
<body>
    {{-- APP CONTENT BEGINS --}}
    <div class="wrapper">
        @yield('content')
    </div>
    {{-- MODALS --}}
    {{-- APP CONTENT ENDS --}}
    {{-- APP SCRIPTS --}} 
</body>
</html>